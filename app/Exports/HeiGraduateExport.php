<?php

namespace App\Exports;

use App\Models\Graduate;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HeiGraduateExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public $search = '';
    public $table_length;
    public $degree_level = '';
    public $only_deleted = '';
    public $selected_hei = '';
    public $academic_year = '';
    public $order_by;

    public function __construct($search, $table_length, $degree_level, $only_deleted, $selected_hei, $academic_year, $order_by)
    {
        $this->search = $search;
        $this->table_length = $table_length;
        $this->degree_level = $degree_level;
        $this->only_deleted = $only_deleted;
        $this->selected_hei = $selected_hei;
        $this->academic_year = $academic_year;
        $this->order_by = $order_by;
    }

    public function collection()
    {
        return Graduate::when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->whereLike('f_name', "%{$this->search}%")
                    ->orWhereLike('l_name', "%{$this->search}%")
                    ->orWhereLike('permanent_address', "%{$this->search}%")
                    ->orWhereLike('email_address', "%{$this->search}%")
                    ->orWhereLike('contact_number', "%{$this->search}%")
                    ->orWhereLike('civil_status', "%{$this->search}%")
                    ->orWhereLike('sex', "%{$this->search}%")
                    ->orWhereLike('birthdate', "%{$this->search}%")
                    ->orWhereLike('location_of_residence', "%{$this->search}%")
                    ->orWhereLike('region', "%{$this->search}%")
                    ->orWhereLike('province', "%{$this->search}%")
                    ->orWhereHas('educationalBackground', function ($educationalBackground) {
                        $educationalBackground->whereLike('degree', "%{$this->search}%");
                    })->orWhereHas('educationalBackground', function ($educationalBackground) {
                        $educationalBackground->whereHas('academicYear', function ($academicYear) {
                            $academicYear->whereLike('start_year', "%{$this->search}%")->orWhereLike('end_year', "%{$this->search}%");
                        });
                    });
            });
        })->when($this->degree_level, function ($query) {
            $query->whereHas('reasonForCourse', function ($q) {
                $q->where('degree_level', $this->degree_level);
            });
        })->when($this->only_deleted, function ($query) {
            $query->onlyTrashed();
        })->when($this->academic_year, function ($query) {
            $query->whereHas('educationalBackground', function ($q) {
                $q->where('academic_year_id', $this->academic_year);
            });
        })->when($this->selected_hei, function ($query) {
            $query->whereHas('educationalBackground', function ($q) {
                $q->where('hei', $this->selected_hei);
            });
        })->when($this->order_by, function ($query) {
            if ($this->order_by === 'province_name') {
                $query->join('provinces', 'graduates.province_id', '=', 'provinces.province_id')
                    ->orderBy('provinces.province_name');
                return;
            }
            $query->orderBy($this->order_by);
        })->whereHas('educationalBackground', function ($query) {
            $query->where('hei', Auth::user()->inst_name);
        })->limit($this->table_length)->get();
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Name Extension',
            'Permanent Address',
            'Email Address',
            'Contact Number',
            'Civil Status',
            'Sex',
            'Birthdate',
            'Region',
            'Province',
            'Location of Residence',
            'Degree',
            'HEI',
        ];
    }

    public function map($graduate): array
    {
        return [
            $graduate->f_name,
            $graduate->l_name,
            $graduate->name_extension,
            $graduate->permanent_address,
            $graduate->email_address,
            $graduate->contact_number,
            $graduate->civil_status,
            $graduate->sex,
            $graduate->birthdate,
            $graduate->region,
            $graduate->province,
            $graduate->location_of_residence,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Row 1 = Headings
        ];
    }
}
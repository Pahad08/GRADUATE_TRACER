<?php

namespace App\Livewire\Hei;

use App\Models\Graduate;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class Graduates extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $table_length = 10;
    public $degree_level = '';
    public $only_deleted = '';
    public $selected_hei = '';

    public function updated($name = '', $value = '')
    {
        $this->resetPage();
    }

    public function render()
    {
        $graduates = Graduate::with([
            'educationalBackground',
            'professionalExamination',
            'reasonForCourse',
            'training',
            'reason',
            'employmentStatus',
            'region',
            'province',
        ])->when($this->search, function ($query) {
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
                    ->orWhereHas('region', function ($regionQuery) {
                        $regionQuery->whereLike('region_name', "%{$this->search}%");
                    })
                    ->orWhereHas('province', function ($provinceQuery) {
                        $provinceQuery->whereLike('province_name', "%{$this->search}%");
                    });
            });
        })->when($this->degree_level, function ($query) {
            $query->whereHas('reasonForCourse', function ($q) {
                $q->where('degree_level', $this->degree_level);
            });
        })->whereHas('educationalBackground', function ($q) {
            $q->where('hei_id', Auth::user()->hei_id);
        })->paginate($this->table_length);

        return view('livewire.hei.graduates', ['graduates' => $graduates]);
    }
}
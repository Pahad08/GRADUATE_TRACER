<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
use App\Models\Graduate;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class Graduates extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $table_length;
    public $degree_level = '';
    public $only_deleted = '';
    public $selected_hei = '';
    public $academic_year = '';
    public $order_by;

    public function updated($name = '', $value = '')
    {
        $this->resetPage();
    }

    protected function isAuthorize()
    {
        return Auth::user()->is_admin;
    }

    public function deleteGraduate($graduate_id)
    {
        if (!$this->isAuthorize()) {
            abort(403);
            return;
        }

        try {
            $graduate_id = decrypt($graduate_id);
        } catch (DecryptException) {
            abort(404);
        }

        $graduate = Graduate::findOrFail($graduate_id);

        $graduate->delete();

        $this->dispatch('graduate-removed', 'Graduate removed successfully.');
    }

    public function restoreGraduate($graduate_id)
    {
        if (!$this->isAuthorize()) {
            abort(403);
            return;
        }

        try {
            $graduate_id = decrypt($graduate_id);
        } catch (DecryptException) {
            abort(404);
        }

        $graduate = Graduate::withTrashed()->findOrFail($graduate_id);
        if (!$graduate->trashed()) {
            $this->dispatch('graduate-restored', 'Graduate is not deleted.');
            return;
        }
        $graduate->restore();
        $this->dispatch('graduate-restored', 'Graduate restored successfully.');
    }

    public function sortGraduates($column_name)
    {
        if ($this->order_by === $column_name) {
            $this->order_by = 'f_name';
            return;
        }

        $this->order_by = $column_name;
    }

    public function mount()
    {
        $this->table_length = 10;
        $this->order_by = 'f_name';
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
            'response.customQuestion',
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
        })->paginate($this->table_length);

        $academic_years = AcademicYear::orderBy('start_year', 'desc')->get();

        return view('livewire.admin.graduates', ['graduates' => $graduates, 'academic_years' => $academic_years]);
    }
}

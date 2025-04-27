<?php

namespace App\Livewire\Admin;

use App\Models\Graduate;
use App\Models\University;
use Livewire\Attributes\Computed;
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
    public $university = '';
    public $universities = '';

    public function mount()
    {
        $this->universities = University::all();
    }

    public function updated($name = '', $value = '')
    {
        $this->resetPage();
    }

    public function deleteGraduate($graduate_id)
    {
        $graduate_id = decrypt($graduate_id);
        $graduate = Graduate::withTrashed()->findOrFail($graduate_id);
        if ($graduate->trashed()) {
            $graduate->forceDelete();
        } else {
            $graduate->delete();
        }
        $this->dispatch('graduate-removed', 'Graduate removed successfully.');
    }

    public function restoreGraduate($graduate_id)
    {
        $graduate_id = decrypt($graduate_id);
        $graduate = Graduate::withTrashed()->findOrFail($graduate_id);
        if (!$graduate->trashed()) {
            $this->dispatch('graduate-restored', 'Graduate is not deleted.');
            return;
        }
        $graduate->restore();
        $this->dispatch('graduate-restored', 'Graduate restored successfully.');
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
        })->when($this->only_deleted, function ($query) {
            $query->onlyTrashed();
        })->when($this->university, function ($query) {
            $query->whereHas('educationalBackground', function ($q) {
                $q->where('university_id', $this->university);
            });
        })
            ->paginate($this->table_length);
        return view('livewire.admin.graduates', ['graduates' => $graduates]);
    }
}

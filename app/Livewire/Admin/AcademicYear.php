<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\AcademicYear as AcademicYearModel;
use Livewire\Attributes\On;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class AcademicYear extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $academic_year_id;
    public $table_length;
    public $start_year;
    public $order_direction;

    public function updated($name = '', $value = '')
    {
        $this->resetPage();
    }

    protected function isAuthorize()
    {
        return Auth::user()->is_admin;
    }

    public function addAcademicYear()
    {
        if (! $this->isAuthorize()) {
            abort(403);
            return;
        }

        $rules = [
            'start_year' => 'required|size:4|unique:academic_years,start_year',
        ];

        $validated = $this->validate($rules);
        $validated['end_year'] = $validated['start_year'] + 1;
        AcademicYearModel::create($validated);
        $this->dispatch('academic-year-created',  'Academic year created!');
        $this->reset('start_year');
    }

    public function editAcademicYear()
    {
        if (!$this->isAuthorize()) {
            abort(403);
            return;
        }

        $rules = [
            'academic_year_id' => 'required|exists:academic_years,academic_year_id',
            'start_year' => 'required|size:4',
        ];

        $validated = $this->validate($rules);
        $validated['end_year'] = $validated['start_year'] + 1;
        $id = $validated['academic_year_id'];
        unset($validated['academic_year_id']);

        AcademicYearModel::where('academic_year_id', $id)->update($validated);

        $this->dispatch('submission-result', message: 'Academic year updated!', color: 'success');
        $this->dispatch('academic-year-updated');
        $this->updateEditInputs();
    }

    #[On('deleteAcademicYear')]
    public function deleteAcademicYear($id)
    {
        if (!$this->isAuthorize()) {
            abort(403);
            return;
        }

        $decrpyted_id = decrypt($id);
        $academic_year = AcademicYearModel::findOrFail($decrpyted_id);

        if (empty($academic_year->academic_year_id)) {
            $this->dispatch('submission-result', message: 'Academic year is invalid.', color: 'error');
            $this->dispatch('academic-year-removed');

            return;
        }

        $academic_year->delete();
        $this->dispatch('academic-year-removed');
        $this->dispatch('submission-result', message: 'Academic year deleted!', color: 'success');
    }

    public function updateEditInputs($id = "", $year = "")
    {
        if (! $this->isAuthorize()) {
            abort(403);
            return;
        }
        $this->start_year = $year;
        $this->academic_year_id = $id;

        $this->resetValidation();
    }

    public function sortAcademicYear()
    {
        $this->order_direction = $this->order_direction === 'desc' ? 'asc' : 'desc';
    }

    public function closeModal()
    {
        $this->updateEditInputs('', '');
        $this->dispatch('modal-close');
    }

    public function mount()
    {
        $this->table_length = 10;
        $this->order_direction = 'desc';
    }

    public function render()
    {
        $academic_years = AcademicYearModel::when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->whereLike('start_year', "%{$this->search}%")
                    ->orWhereLike('end_year', "%{$this->search}%");
            });
        })->orderBy('start_year', $this->order_direction)->paginate($this->table_length);

        return view('livewire.admin.academic-year', ['academic_years' => $academic_years]);
    }
}

<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\HEI;
use Illuminate\Support\Facades\Auth;

class HEIList extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $table_length = 10;
    public $only_deleted = '';
    public $hei_name = '';
    public $edit_hei_name = '';
    public $edit_hei_id = '';

    protected function isAuthorize()
    {
        if (Auth::user()->hei_id !== null) {
            abort(401);
            return;
        }
    }

    public function deleteHEI($hei_id)
    {
        $this->isAuthorize();
        $hei_id = decrypt($hei_id);
        $hei = HEI::withTrashed()->findOrFail($hei_id);
        if ($hei->trashed()) {
            $hei->forceDelete();
        } else {
            $hei->delete();
        }
        $this->dispatch('hei-removed', 'HEI removed successfully.');
    }

    public function updateEditInputs($id, $name)
    {
        $this->isAuthorize();

        $this->edit_hei_id = $id;
        $this->edit_hei_name = $name;

        $this->resetValidation();
    }

    public function updated($name = '', $value = '')
    {
        $this->resetPage();
    }

    public function restoreHEI($hei_id)
    {
        $this->isAuthorize();

        $hei_id = decrypt($hei_id);
        $hei = HEI::withTrashed()->findOrFail($hei_id);
        if (!$hei->trashed()) {
            $this->dispatch('hei-restored', 'HEI is not deleted.');
            return;
        }
        $hei->restore();
        $this->dispatch('hei-restored', 'HEI restored successfully.');
    }

    public function saveHEI()
    {
        $this->isAuthorize();

        $rules = [
            'hei_name' => 'required',
        ];

        $validated = $this->validate($rules);

        HEI::create([
            'hei_name' => $validated['hei_name'],
        ]);

        $this->dispatch('hei-created', 'HEI created!');
        $this->reset();
    }

    public function editHEI()
    {
        $this->isAuthorize();

        $rules = [
            'edit_hei_id' => 'required|exists:hei,hei_id',
            'edit_hei_name' => 'required',
        ];

        $validated = $this->validate($rules);

        HEI::where('hei_id', $validated['edit_hei_id'])->update([
            'hei_name' => $validated['edit_hei_name'],
        ]);

        $this->dispatch('hei-updated', 'HEI updated!');
    }

    public function render()
    {
        $hei = HEI::when($this->only_deleted, function ($query) {
            $query->onlyTrashed();
        })->when($this->search, function ($query) {
            $query->whereLike('hei_name', "%{$this->search}%");
        })->paginate($this->table_length);

        return view('livewire.admin.HEI-list', ['heis' => $hei]);
    }
}

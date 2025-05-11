<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HEI extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $only_deleted = '';
    public $hei_search = '';
    public $hei_form_search = '';
    public $hei_results = [];
    public $hei_form_results = [];
    public $selected_hei = '';
    public $table_length = 10;
    public $username = '';
    public $edit_username = '';
    public $account_id = '';
    public $password = '';
    public $selected_form_hei = '';

    protected function isAuthorize()
    {
        if (Auth::user()->hei_id !== null) {
            abort(401);
            return;
        }
    }

    public function updated($name = '', $value = '')
    {
        $this->resetPage();
    }

    public function updateEditInputs($id, $username)
    {
        $this->isAuthorize();
        $this->edit_username = $username;
        $this->account_id = $id;

        $this->resetValidation();
    }

    public function addHeiAccount()
    {
        $this->isAuthorize();

        $rules = [
            'username' => 'required',
            'selected_form_hei' => 'required|exists:hei,hei_id'
        ];

        $validated = $this->validate($rules);

        User::create([
            'username' => $validated['username'],
            'hei_id' => $validated['selected_form_hei'],
            'password' => Hash::make('12345')
        ]);

        $this->dispatch('account-created', 'Account created!');

        $this->reset('username', 'selected_form_hei');
    }

    public function editHEIAccount()
    {
        $this->isAuthorize();

        $rules = [
            'account_id' => 'required|exists:users,user_id',
            'edit_username' => 'required',
            'password' => 'nullable'
        ];

        $message = [
            'account_id.required' => 'The account is invalid.',
            'edit_username.required' => 'The username is required.',
        ];

        $validated = $this->validate($rules, $message);
        $validated['username'] = $validated['edit_username'];
        $id = $validated['account_id'];
        unset($validated['account_id']);
        unset($validated['edit_username']);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        User::where('user_id', $id)->update($validated);

        $this->dispatch('account-updated', 'HEI account updated!');
    }

    public function deleteAccount($account_id)
    {
        $this->isAuthorize();

        $account_id = decrypt($account_id);
        $account = User::withTrashed()->findOrFail($account_id);

        if (empty($account->hei_id)) {
            $this->dispatch('account-delete-fail', 'Account is invalid.');
            return;
        }

        if ($account->trashed()) {
            $account->forceDelete();
        } else {
            $account->delete();
        }
        $this->dispatch('account-removed', 'Account removed successfully.');
    }

    public function restoreAccount($account_id)
    {
        $this->isAuthorize();

        $account_id = decrypt($account_id);
        $account = User::withTrashed()->findOrFail($account_id);
        if (!$account->trashed()) {
            $this->dispatch('account-restored', 'Account is not deleted.');
            return;
        }
        $account->restore();
        $this->dispatch('account-restored', 'Account restored successfully.');
    }

    public function render()
    {
        $accounts = User::with('hei:hei_id,hei_name')
            ->whereNotNull('hei_id')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereLike('username', "%{$this->search}%")
                        ->orWhereHas('hei', function ($hei) {
                            $hei->whereLike('hei_name', "%{$this->search}%");
                        });
                });
            })->when($this->only_deleted, function ($query) {
                $query->onlyTrashed();
            })
            ->when($this->selected_hei, function ($query) {
                $query->whereHas('hei', function ($q) {
                    $q->where('hei_id', $this->selected_hei);
                });
            })
            ->paginate($this->table_length);

        return view('livewire.admin.HEI', ['accounts' => $accounts]);
    }
}

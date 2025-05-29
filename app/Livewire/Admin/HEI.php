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
    public $hei_search = '';
    public $hei_form_search = '';
    public $hei_results = [];
    public $hei_form_results = [];
    public $selected_hei = '';
    public $table_length = 10;
    public $edit_username = '';
    public $account_id = '';
    public $password = '';
    public $inst_code = '';
    public $inst_name = '';

    protected function isAuthorize()
    {
        return Auth::user()->is_admin;
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

    protected function generateAcronym($string, $skipWords = ['of', '&', 'and'])
    {

        $string = str_replace(',', '', $string);

        if (strpos($string, '-') !== false) {
            [$main, $suffix] = array_map('trim', explode('-', $string, 2));
        } else {
            $main = $string;
            $suffix = null;
        }

        $words = preg_split('/\s+/', $main);
        $acronym = '';

        foreach ($words as $word) {
            if (!in_array(strtolower($word), $skipWords) && !empty($word)) {
                $acronym .= strtoupper($word[0]);
            }
        }

        return $suffix ? $acronym . '-' . strtoupper($suffix) : $acronym;
    }

    public function addHeiAccount()
    {
        if (!$this->isAuthorize()) {
            abort(403);
            return;
        }

        $rules = [
            'inst_code' => 'required|unique:users,inst_id'
        ];

        $message = [
            'inst_code.required' => 'HEI field is required.'
        ];

        $validated = $this->validate($rules, $message);

        User::create([
            'username' => $this->generateAcronym($this->inst_name),
            'inst_name' => $this->inst_name,
            'inst_id' => $validated['inst_code'],
            'password' => Hash::make('chedro12')
        ]);

        $this->dispatch('account-created', 'Account created!');

        $this->reset(['inst_code', 'inst_name']);
    }

    public function editHEIAccount()
    {
        if (! $this->isAuthorize()) {
            abort(403);
            return;
        }

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
        $validated['password'] = Hash::make($validated['password']);

        User::where('user_id', $id)->update($validated);
        $this->reset('password');
        $this->dispatch('account-updated', 'HEI account updated!');
    }

    public function deleteAccount($account_id)
    {
        if (! $this->isAuthorize()) {
            abort(403);
            return;
        }

        $account_id = decrypt($account_id);
        $account = User::find($account_id);

        if (empty($account->inst_id)) {
            $this->dispatch('account-delete-fail', 'Account is invalid.');
            return;
        }

        $account->delete();
        $this->dispatch('account-removed', 'Account removed successfully.');
    }

    public function closeModal()
    {
        $this->updateEditInputs('', '');
        $this->dispatch('modal-close');
    }

    public function render()
    {
        $accounts = User::whereNotNull('inst_name')
            ->whereNotNull('inst_id')
            ->where('is_admin', 0)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereLike('username', "%{$this->search}%")
                        ->orwhereLike('inst_name', "%{$this->search}%");
                });
            })->when($this->selected_hei, function ($query) {
                $query->where('inst_name', $this->selected_hei);
            })->paginate($this->table_length);

        return view(
            'livewire.admin.HEI',
            ['accounts' => $accounts]
        );
    }
}
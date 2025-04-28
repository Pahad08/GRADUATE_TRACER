<?php

namespace App\Livewire\Admin\Graduates;

use Livewire\Component;

class EmploymentData extends Component
{
    public $employment_data;

    public function mount($graduate)
    {
        $this->employment_data = $graduate->employmentStatus;
    }

    public function render()
    {
        return view('livewire.admin.graduates.employment-data');
    }
}
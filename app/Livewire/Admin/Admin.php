<?php

namespace App\Livewire\Admin;

use App\Models\EducationalBackground;
use App\Models\Graduate;
use Livewire\Component;

class Admin extends Component
{
    public $total_graduates;
    public $total_employed;
    public $total_unemployed;
    public $year;

    public function updatedYear()
    {
        $this->total_graduates = Graduate::with(['EducationalBackground'])
            ->whereHas('EducationalBackground', function ($q) {
                $q->where('year_graduated', $this->year);
            })->count();
        $this->total_employed = Graduate::with(['employmentStatus', 'EducationalBackground'])
            ->whereHas('employmentStatus', function ($query) {
                $query->where('is_employed', 'yes');
            })->whereHas('EducationalBackground', function ($q) {
                $q->where('year_graduated', $this->year);
            })->count();
    }

    public function mount()
    {
        $this->total_graduates = Graduate::count();
        $this->total_employed = Graduate::with(['employmentStatus', 'EducationalBackground'])
            ->whereHas('employmentStatus', function ($query) {
                $query->where('is_employed', 'yes');
            })->count();
    }

    public function render()
    {
        $years = EducationalBackground::select('year_graduated')->distinct()->orderBy('year_graduated', 'desc')->get();
        return view('livewire.admin.admin', ['years' => $years]);
    }
}

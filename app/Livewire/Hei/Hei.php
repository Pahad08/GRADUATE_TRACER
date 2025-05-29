<?php

namespace App\Livewire\Hei;

use App\Models\AcademicYear;
use App\Models\Graduate;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class Hei extends Component
{
    public $academic_year;
    public $academic_year_id;
    public $employment_status;
    public $graduates_per_year;
    public $graduates_per_year_axis;
    public $data;

    public function updatedAcademicYearId()
    {
        $this->updatedYear();
    }

    protected function getEmploymentStatus()
    {
        return Graduate::with([
            'employmentStatus:employment_status_id,graduate_id,is_employed',
            'EducationalBackground:educational_background_id,academic_year_id'
        ])
            ->whereHas('EducationalBackground', function ($query) {
                $query->where('hei', Auth::user()->inst_name);
            })
            ->select('graduate_id')
            ->when($this->academic_year_id, function ($query) {
                $query->whereHas('EducationalBackground', function ($educationalBackground) {
                    $educationalBackground->where('academic_year_id', $this->academic_year_id);
                });
            })
            ->get()
            ->groupBy(function ($graduate) {
                $status = $graduate->employmentStatus->is_employed;
                return $status === 'yes' ? 'employed' : 'unemployed';
            })
            ->map(fn($group) => $group->count())
            ->sortByDesc(fn($count, $status) => $status === 'employed' ? 1 : 0)
            ->toArray();
    }

    protected function getMaleGraduatesPerYear()
    {
        return AcademicYear::withCount([
            'educationalBackground as male_graduates_count' => function ($query) {
                $query->whereHas('graduates', function ($q) {
                    $q->where('sex', 'male');
                })->where('hei', Auth::user()->inst_name);
            }
        ])->when($this->academic_year_id, function ($query) {
            $query->where('academic_year_id', $this->academic_year_id);
        })->orderBy('start_year', 'desc')->get()->pluck('male_graduates_count')->toArray();
    }

    protected function getFeMaleGraduatesPerYear()
    {
        return AcademicYear::withCount([
            'educationalBackground as female_graduates_count' => function ($query) {
                $query->whereHas('graduates', function ($q) {
                    $q->where('sex', 'female');
                })->where('hei', Auth::user()->inst_name);
            }
        ])->when($this->academic_year_id, function ($query) {
            $query->where('academic_year_id', $this->academic_year_id);
        })->orderBy('start_year', 'desc')->get()->pluck('female_graduates_count')->toArray();
    }

    protected function getgraduatesPerYearAxis()
    {
        return AcademicYear::when($this->academic_year_id, function ($query) {
            $query->where('academic_year_id', $this->academic_year_id);
        })->orderBy('start_year', 'desc')->get()->map(function ($year) {
            return $year->start_year . "-" .  $year->end_year;
        })->toArray();
    }

    protected function loadChartData()
    {
        $this->employment_status = $this->getEmploymentStatus();
        $this->graduates_per_year = [
            ["name" => "Male", 'data' => $this->getMaleGraduatesPerYear()],
            ["name" => "Female", 'data' => $this->getFeMaleGraduatesPerYear()]
        ];
        $this->graduates_per_year_axis = $this->getgraduatesPerYearAxis();
    }

    protected function updatedYear()
    {
        $this->loadChartData();
        $academic_year = AcademicYear::find($this->academic_year_id);
        if ($academic_year) {
            $this->academic_year = $academic_year->start_year . "-" . $academic_year->end_year;
        } else {
            $this->academic_year = "";
        }

        $employed_chart_color = null;
        if (isset(collect($this->employment_status)->keys()->values()->toArray()[0])) {
            $employed_chart_color = collect($this->employment_status)->keys()->values()->toArray()[0] == "employed"
                ? "#00A43B"
                : "#FF6266";
        }

        $employed_status_options = [
            "chart" => ["type" => "donut", "height" => "300px"],
            "labels" => collect($this->employment_status)->keys()->values()->toArray(),
            "colors" => count($this->employment_status) > 1 ? ["#00A43B", "#FF6266"] : [$employed_chart_color],
            'count' => count($this->employment_status)
        ];

        $graduates_per_year_options = [
            "chart" => [
                "type" => "bar",
                "height" => 430,
            ],
            "plotOptions" => [
                "bar" => [
                    "horizontal" => true,
                    "dataLabels" => [
                        "position" => "top",
                    ],
                ],
            ],
            "dataLabels" => [
                "enabled" => true,
                "offsetX" => -6,
                "style" => [
                    "fontSize" => "12px",
                    "colors" => ["#fff"],
                ],
            ],
            "stroke" => [
                "show" => true,
                "width" => 1,
                "colors" => ["#fff"],
            ],
            "tooltip" => [
                "shared" => true,
                "intersect" => false,
            ],
            "xaxis" => [
                "categories" => $this->graduates_per_year_axis,
            ],
            "colors" => ["#0082CE", "#FF6266"],
        ];

        $this->dispatch(
            'year-changed',
            employment_status: ['series' => array_values($this->employment_status), 'options' => $employed_status_options],
            graduates_per_year: ['series' => $this->graduates_per_year, 'options' => $graduates_per_year_options],
        );
    }

    public function mount()
    {
        $this->academic_year_id = '';
        $this->academic_year = '';
        $this->loadChartData();
    }

    public function render()
    {
        $total_graduates = Graduate::with(['EducationalBackground'])
            ->whereHas('EducationalBackground', function ($query) {
                $query->where('hei', Auth::user()->inst_name);
            })->when($this->academic_year_id, function ($query) {
                $query->whereHas('EducationalBackground', function ($q) {
                    $q->where('academic_year_id', $this->academic_year_id);
                });
            })->count();

        $total_employed = Graduate::with(['employmentStatus', 'EducationalBackground'])
            ->whereHas('EducationalBackground', function ($query) {
                $query->where('hei', Auth::user()->inst_name);
            })
            ->whereHas('employmentStatus', function ($query) {
                $query->where('is_employed', 'yes');
            })->when($this->academic_year_id, function ($query) {
                $query->whereHas('EducationalBackground', function ($q) {
                    $q->where('academic_year_id', $this->academic_year_id);
                });
            })->count();

        $total_unemployed = Graduate::with(['employmentStatus', 'EducationalBackground'])
            ->whereHas('EducationalBackground', function ($query) {
                $query->where('hei', Auth::user()->inst_name);
            })
            ->whereHas('employmentStatus', function ($query) {
                $query->whereNot('is_employed', 'yes');
            })->when($this->academic_year_id, function ($query) {
                $query->whereHas('EducationalBackground', function ($q) {
                    $q->where('academic_year_id', $this->academic_year_id);
                });
            })->count();

        $academic_years = AcademicYear::orderBy('start_year', 'desc')->get();

        return view('livewire.hei.hei', [
            'total_graduates' => $total_graduates,
            'total_employed' => $total_employed,
            'total_unemployed' => $total_unemployed,
            'academic_years' => $academic_years
        ]);
    }
}
<div id="root">
    <livewire:components.hei.header />

    <div class="mt-0" x-data="{ active: 'admin.questions.general-information' }">
        <div class="rounded-lg px-3">
            <div class="md:w-300 mx-auto my-5 w-full max-w-full rounded">
                <div class="breadcrumbs text-sm">
                    <ul>
                        <li>
                            <span class="inline-flex items-center gap-2">
                                <i class="fa-solid fa-chart-simple"></i>
                                Analytics
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="mt-2 rounded-lg">
                    <div>
                        <div class="card flex flex-row gap-3">
                            <div>
                                <label class="text-neutral mb-1 block text-sm font-semibold">Academic Year</label>
                                <select wire:model.live='academic_year_id'
                                    class="select select-sm @error("form.civil_status") select-error @enderror w-full bg-white">
                                    <option value="">Select Academic year</option>
                                    @foreach ($academic_years as $y)
                                        <option value="{{ $y->academic_year_id }}">
                                            {{ $y->start_year . "-" . $y->end_year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <p class="my-2 text-sm">Selected academic year: <span
                                class="text-primary font-semibold">{{ $academic_year }}</span></p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="mt-2 grid grid-cols-1 gap-4 self-start md:grid-cols-1">
                            <livewire:components.admin.dashboard-card lazy icon="fa-user-graduate"
                                title="Total Graduates" :total="$total_graduates" />

                            <livewire:components.admin.dashboard-card lazy icon="fa-user-tie" title="Total Employed"
                                :total="$total_employed" color="success" />

                            <livewire:components.admin.dashboard-card lazy icon="fa-user-xmark" title="Total Unemployed"
                                :total="$total_unemployed" color='error' />
                        </div>

                        <div class="mt-2 grid grid-cols-1 gap-4 md:col-span-2">
                            @php
                                $employed_chart_color = null;
                                if (collect($this->employment_status)->keys()->values()->toArray()) {
                                    collect($this->employment_status)->keys()->values()->toArray()[0] == "employed"
                                        ? "#00A43B"
                                        : "#FF6266";
                                }

                                $employed_status_options = [
                                    "chart" => ["type" => "donut", "height" => "300px"],
                                    "series" => array_values($employment_status),
                                    "labels" => collect($employment_status)->keys()->values()->toArray(),
                                    "colors" =>
                                        count($employment_status) > 1
                                            ? ["#00A43B", "#FF6266"]
                                            : [$employed_chart_color],
                                ];
                            @endphp
                            <livewire:components.admin.chart title="Employment Status" id="employment-chart"
                                :options="$employed_status_options" data_to_fetch="employment_status" />

                            @php
                                $graduates_per_year_options = [
                                    "series" => $graduates_per_year,
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
                                        "categories" => $graduates_per_year_axis,
                                    ],
                                    "colors" => ["#0082CE", "#FF6266"],
                                ];
                            @endphp
                            <livewire:components.admin.chart title="Graduates per year" id="graduates-per-year-chart"
                                :options="$graduates_per_year_options" data_to_fetch="graduates_per_year" />

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

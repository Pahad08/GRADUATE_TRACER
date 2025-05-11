<div id="root">

    <livewire:components.admin.header />

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
                    <div class="mt-2">
                        <div class="card flex flex-row gap-3">
                            <div>
                                <label class="text-neutral mb-2 block text-sm font-semibold">Year</label>
                                <select wire:model.live='year'
                                    class="select select-sm @error("form.civil_status") select-error @enderror w-full bg-white">
                                    @foreach ($years as $year)
                                        <option>{{ $year->year_graduated }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <livewire:components.admin.dashboard-card lazy icon="fa-user-graduate" title="Total Graduates"
                            :total="$total_graduates" />

                        <livewire:components.admin.dashboard-card lazy icon="fa-user-tie" title="Total Employed"
                            :total="$total_employed" color='success' />

                        <livewire:components.admin.dashboard-card lazy icon="fa-user-xmark" title="Total Unemployed"
                            :total="$total_employed" color='error' />
                    </div>

                    <!-- Charts -->
                    <div class="mt-2 grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Employment Status -->
                        <div class="card bg-white p-4 shadow">
                            <h2 class="mb-2 font-semibold">Employment Status</h2>
                            <div id="employmentChart"></div>
                        </div>

                        <!-- Salary Distribution -->
                        <div class="card bg-white p-4 shadow">
                            <h2 class="mb-2 font-semibold">Salary Distribution</h2>
                            <div id="salaryChart"></div>
                        </div>
                    </div>

                    <!-- Trend Chart -->
                    <div class="card bg-white p-4 shadow">
                        <h2 class="mb-2 font-semibold">Graduates Over the Years</h2>
                        <div id="trendChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @script
        <script>
            const options1 = {
                chart: {
                    type: 'donut'
                },
                series: [1780, 650],
                labels: ['Employed', 'Unemployed'],
                colors: ['#34D399', '#F87171'],
            };
            new ApexCharts(document.querySelector("#employmentChart"), options1).render();

            // Salary Bar Chart
            const options2 = {
                chart: {
                    type: 'bar'
                },
                series: [{
                    name: 'Graduates',
                    data: [100, 450, 780, 310, 90]
                }],
                xaxis: {
                    categories: ['<20k', '20k-40k', '40k-60k', '60k-80k', '80k+']
                },
                colors: ['#60A5FA']
            };
            new ApexCharts(document.querySelector("#salaryChart"), options2).render();

            // Yearly Line Chart
            const options3 = {
                chart: {
                    type: 'line'
                },
                series: [{
                    name: 'Graduates',
                    data: [1200, 1350, 1500, 1600, 1800, 1900]
                }],
                xaxis: {
                    categories: ['2019', '2020', '2021', '2022', '2023', '2024']
                },
                colors: ['#818CF8']
            };
            new ApexCharts(document.querySelector("#trendChart"), options3).render()
        </script>
    @endscript
</div>

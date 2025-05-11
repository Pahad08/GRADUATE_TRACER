<div>
    <livewire:components.hei.header />

    <div class="mt-0" x-data="{ active: 'admin.questions.general-information' }">
        <div class="rounded-lg px-3">
            <div class="md:w-300 mx-auto my-5 w-full max-w-full rounded">
                <div class="breadcrumbs text-sm">
                    <ul>
                        <li>
                            <a wire:navigate href="/home">
                                <i class="fa-solid fa-chart-simple"></i>
                                Analytics
                            </a>
                        </li>
                        <li>
                            <span class="inline-flex items-center gap-2">
                                <i class="fa-solid fa-user-graduate"></i>
                                Graduates
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="mt-2 rounded-lg shadow-md">
                    <div
                        class="bg-secondary text-secondary-content flex items-center justify-between rounded-t-lg px-4 py-3">
                        <h2 class="text-lg font-semibold">Graduates</h2>
                    </div>

                    <div class="bg-base-100 rounded-b-lg">
                        <div class="flex flex-col justify-between gap-2 p-4 md:flex-row md:items-center">
                            <div class="join">
                                <input wire:model.live.debounce.250ms='search' type="text"
                                    class="input input-sm input-bordered join-item w-full"
                                    placeholder="Filter graduates..." />
                                <span class="bg-primary join-item flex items-center justify-center px-3">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                            </div>

                            <div class="flex items-center gap-2">

                                <select wire:model.live='degree_level' class="select select-sm w-full">
                                    <option value="">Graduate Type</option>
                                    <option value="graduate">Graduate</option>
                                    <option value="undergraduate">Under Graduate</option>
                                </select>

                                <select wire:model.live='table_length' class="select select-sm w-full">
                                    <option value="10">10</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>

                        <div class="overflow-x-auto px-4">
                            <table class="table">
                                <thead>
                                    <tr class="bg-neutral-content">
                                        <th class="whitespace-nowrap">First Name</th>
                                        <th class="whitespace-nowrap">Last Name</th>
                                        <th class="whitespace-nowrap">Permanent Address</th>
                                        <th class="whitespace-nowrap">Email Address</th>
                                        <th class="whitespace-nowrap">Contact Number</th>
                                        <th class="whitespace-nowrap">Civil Status</th>
                                        <th class="whitespace-nowrap">Sex</th>
                                        <th class="whitespace-nowrap">Birthday</th>
                                        <th class="whitespace-nowrap">Region</th>
                                        <th class="whitespace-nowrap">Province</th>
                                        <th class="whitespace-nowrap">Location of Residence</th>
                                        <th class="whitespace-nowrap text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($graduates as $key => $graduate)
                                        <livewire:components.tableRow.graduate-table-tr lazy="on-load" :num="$key"
                                            :key="$graduate->graduate_id" :graduate="$graduate" />
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-2 px-4 py-2">
                            {{ $graduates->onEachSide(1)->links(data: ["scrollTo" => false]) }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

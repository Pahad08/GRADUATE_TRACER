<div>
    <livewire:components.admin.header />

    <div class="mt-0" x-data="{ active: 'admin.questions.general-information' }">
        <div class="rounded-lg px-3">
            <div class="md:w-300 mx-auto my-5 w-full max-w-full rounded">
                <div class="flex flex-col justify-between gap-y-3 md:flex-row md:items-center">
                    <div class="breadcrumbs text-sm">
                        <ul>
                            <li>
                                <a wire:navigate href="{{ route("dashboard") }}">
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

                    <button wire:click='exportGraduate' wire:loading.attr='disabled' class="btn btn-success btn-sm"><i
                            class="fa-solid fa-file-excel"></i>
                        Export Excel</button>
                </div>

                <div class="mt-2 rounded-lg shadow-md">
                    <div class="bg-base-300 text-base-content flex items-center justify-between rounded-t-lg px-4 py-3">
                        <h2 class="text-lg font-semibold">Graduates</h2>
                    </div>

                    <div class="bg-base-100 border-base-300 rounded-b-lg border">
                        <div class="flex flex-col justify-between gap-2 p-4 md:flex-row md:items-center">
                            <div>
                                <label class="input input-sm w-full">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <input wire:model.live.debounce.250ms='search' type="text"
                                        placeholder="Filter graduates..." />
                                </label>
                            </div>

                            <div class="flex items-center gap-2">
                                <div x-data="{
                                    open: false,
                                    search: '',
                                    results: {},
                                    isLoading: false,
                                    get filtered() {
                                        return Object.entries(this.results).filter(([_, hei]) =>
                                            this.search === '' || hei.toLowerCase().includes(this.search.toLowerCase())
                                        );
                                    },
                                    reset() {
                                        if (this.search == '') {
                                            $wire.set('selected_hei', '');
                                        }
                                        this.open = false;
                                    }
                                }" @click.outside="if (open) reset()"
                                    class="relative h-full w-full">
                                    <input
                                        x-on:focus="open = true; 
                                    if(Object.keys(results).length === 0){
                                        isLoading = true;
                                    (async () => {
                                    try {
                                        const response = await fetch('/fetch-hei', {
                                            method: 'GET',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'PORTAL-API': '{{ config("services.PORTAL_API") }}',
                                            }
                                        });
                                        const data = await response.json();
                                        isLoading = false;
                                        results = data;
                                    } catch (error) {
                                        console.error('Fetch failed', error);
                                        results = { error: 'Error fetching data' };
                                    }})()
                                    };"x-model="search"
                                        type="text" class="input input-sm w-full bg-white"
                                        placeholder="Search HEI" />

                                    <ul x-show="open" x-transition
                                        class="border-base-300 w-50 absolute z-50 mt-1 max-h-60 overflow-y-auto rounded-md border bg-white shadow-md">
                                        <template x-if="filtered.length > 0">
                                            <template x-for="[hei_key, hei] in filtered" :key="hei_key">
                                                <li x-on:click="open = false; $wire.set('selected_hei', hei); search = hei;"
                                                    class="hover:bg-primary hover:text-base-100 cursor-pointer p-3 text-sm"
                                                    x-text="hei"></li>
                                            </template>
                                        </template>

                                        <template x-if="Object.keys(filtered).length === 0 && !isLoading">
                                            <li class="p-3">No data found.</span>
                                            </li>
                                        </template>

                                        <template x-if="isLoading">
                                            <li class="p-3"><span
                                                    class="loading loading-spinner loading-md"></span></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>

                                <select wire:model.live='academic_year' class="select select-sm w-full">
                                    <option value="">Academic Year</option>
                                    @foreach ($academic_years as $y)
                                        <option value="{{ $y->academic_year_id }}">
                                            {{ $y->start_year . "-" . $y->end_year }}</option>
                                    @endforeach
                                </select>

                                <select wire:model.live='only_deleted' class="select select-sm w-full">
                                    <option value="">Graduates</option>
                                    <option value="1">Deleted Graduates</option>
                                </select>

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
                                    <tr>
                                        <th class="cursor-pointer whitespace-nowrap"
                                            wire:click='sortGraduates("f_name")'><span>First Name <i
                                                    @class([
                                                        "fa-solid fa-sort-up" => $order_by == "f_name",
                                                        "fa-solid fa-sort-down" => $order_by !== "f_name",
                                                    ])></i></span></th>
                                        <th class="cursor-pointer whitespace-nowrap"
                                            wire:click='sortGraduates("l_name")'>Last Name <i
                                                @class([
                                                    "fa-solid fa-sort-up" => $order_by == "l_name",
                                                    "fa-solid fa-sort-down" => $order_by !== "l_name",
                                                ])></i></th>
                                        <th class="whitespace-nowrap">Permanent Address</th>
                                        <th class="cursor-pointer whitespace-nowrap"
                                            wire:click='sortGraduates("email_address")'>Email Address <i
                                                @class([
                                                    "fa-solid fa-sort-up" => $order_by == "email_address",
                                                    "fa-solid fa-sort-down" => $order_by !== "email_address",
                                                ])></i>
                                        </th>
                                        <th class="whitespace-nowrap">Contact Number</th>
                                        <th class="cursor-pointer whitespace-nowrap"
                                            wire:click='sortGraduates("civil_status")'>Civil Status <i
                                                @class([
                                                    "fa-solid fa-sort-up" => $order_by == "civil_status",
                                                    "fa-solid fa-sort-down" => $order_by !== "civil_status",
                                                ])></i>
                                        </th>
                                        <th class="whitespace-nowrap">Sex</th>
                                        <th class="cursor-pointer whitespace-nowrap"
                                            wire:click='sortGraduates("birthdate")'>Birthday <i
                                                @class([
                                                    "fa-solid fa-sort-up" => $order_by == "birthdate",
                                                    "fa-solid fa-sort-down" => $order_by !== "birthdate",
                                                ])></i>
                                        </th>
                                        <th class="whitespace-nowrap">Region</th>
                                        <th class="cursor-pointer whitespace-nowrap"
                                            wire:click='sortGraduates("province_name")'>Province <i
                                                @class([
                                                    "fa-solid fa-sort-up" => $order_by == "province_name",
                                                    "fa-solid fa-sort-down" => $order_by !== "province_name",
                                                ])></i>
                                        </th>
                                        <th class="whitespace-nowrap">Location of Residence</th>
                                        <th class="whitespace-nowrap text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($graduates as $key => $graduate)
                                        <livewire:components.tableRow.graduate-table-tr lazy="on-load" :key="$graduate->graduate_id"
                                            :graduate="$graduate" />
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

    <input type="checkbox" id="remove-graduate" class="modal-toggle" />
    <div x-data='{ id: ""}' id="delete_confirmation_modal" class="modal"
        x-on:remove-graduate.window="id=$event.detail.id;" x-on:graduate-removed.window="id=''">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Confirm Deletion</h3>
            <p class="py-4">Are you sure you want to delete this graduate?</p>
            <div class="modal-action">
                <label for="remove-graduate" class="btn btn-sm" x-on:graduate-removed.window="$el.click()">Close</label>

                <button class="btn btn-sm btn-error" wire:loading.attr='disabled' wire:click='deleteGraduate(id);'>
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>

    <input type="checkbox" id="restore-graduate" class="modal-toggle" />
    <div x-data='{ id: ""}' id="restore_confirmation_modal" class="modal"
        x-on:restore-graduate.window="id=$event.detail.id;" x-on:graduate-restored.window="id=''">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Confirm Restoration</h3>
            <p class="py-4">Are you sure you want to restore this graduate?</p>
            <div class="modal-action">
                <label for="restore-graduate" class="btn btn-sm"
                    x-on:graduate-restored.window="$el.click()">Close</label>
                <button class="btn btn-sm btn-success" wire:loading.attr='disabled'
                    wire:click='restoreGraduate(id);'>
                    Yes, Restore
                </button>
            </div>
        </div>
    </div>

    <div x-data="{ message: '', show: false, timeout: null }" class="toast toast-end"
        x-on:graduate-removed.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
        show = true; timeout= setTimeout(() => show = false, 2000);"
        x-on:graduate-restored.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
        show = true; timeout= setTimeout(() => show = false, 2000);">
        <template x-if="show">
            <div class="toast toast-end">
                <div class="alert alert-success">
                    <span x-text="message"></span>
                </div>
            </div>
        </template>
    </div>
</div>

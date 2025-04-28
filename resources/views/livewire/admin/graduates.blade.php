<div>
    <livewire:components.admin.header />

    <div class="mt-0" x-data="{ active: 'admin.questions.general-information' }">
        <div class="rounded-lg px-3">
            <div class="md:w-300 mx-auto my-5 w-full max-w-full rounded">
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

                <div class="border-1 border-base-300 mt-2 rounded-lg shadow-md">
                    <div class="bg-secondary text-base-100 flex items-center justify-between rounded-t-lg px-4 py-3">
                        <h2 class="text-lg font-semibold">Graduates</h2>
                    </div>

                    <div class="bg-base-100 rounded-b-lg">
                        <div
                            class="border-base-300 flex flex-col justify-between gap-2 p-4 md:flex-row md:items-center">
                            <div class="join">
                                <input wire:model.live.debounce.250ms='search' type="text"
                                    class="input input-sm input-bordered join-item w-full"
                                    placeholder="Filter graduates..." />
                                <span class="bg-primary join-item flex items-center justify-center px-3">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                            </div>

                            <div class="flex items-center gap-2">
                                <select wire:model.live='only_deleted' class="select select-sm">
                                    <option value="">Graduates</option>
                                    <option value="1">Deleted Graduates</option>
                                </select>

                                <select wire:model.live='university' id="university" class="select select-sm">
                                    <option value="">University</option>
                                    @foreach (\App\Models\University::all() as $university)
                                        <option value="{{ $university->university_id }}">
                                            {{ $university->university_name }}</option>
                                    @endforeach
                                </select>

                                <select wire:model.live='degree_level' class="select select-sm">
                                    <option value="">Graduate Type</option>
                                    <option value="graduate">Graduate</option>
                                    <option value="undergraduate">Under Graduate</option>
                                </select>

                                <select wire:model.live='table_length' class="select select-sm">
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
                                        <livewire:components.graduate-table-tr lazy="on-load" :num="$key"
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

    <input type="checkbox" id="remove-graduate" class="modal-toggle" />
    <div x-data='{ id: ""}' id="delete_confirmation_modal" class="modal"
        x-on:remove-graduate.window="id=$event.detail.id" x-on:graduate-removed.window="id=''">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Confirm Deletion</h3>
            <p class="py-4">Are you sure you want to delete this graduate?</p>
            <div class="modal-action">
                <label for="remove-graduate" class="btn" x-on:graduate-removed.window="$el.click()">Close</label>

                <button class="btn btn-error text-white" wire:loading.attr='disabled' wire:click='deleteGraduate(id);'>
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>

    <input type="checkbox" id="restore-graduate" class="modal-toggle" />
    <div x-data='{ id: ""}' id="restore_confirmation_modal" class="modal"
        x-on:restore-graduate.window="id=$event.detail.id" x-on:graduate-restored.window="id=''">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Confirm Restoration</h3>
            <p class="py-4">Are you sure you want to restore this graduate?</p>
            <div class="modal-action">
                <label for="restore-graduate" class="btn" x-on:graduate-restored.window="$el.click()">Close</label>
                <button class="btn btn-success text-white" wire:loading.attr='disabled'
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

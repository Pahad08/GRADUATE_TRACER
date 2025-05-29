<div id="root">

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
                                    <i class="fa-solid fa-school"></i>
                                    Academic Year
                                </span>
                            </li>
                        </ul>
                    </div>

                    <label for="add-academic-year-modal" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i>
                        Add Academic Year</label>
                </div>

                <div class="mt-2 rounded-lg shadow-md">
                    <div class="bg-base-300 flex items-center justify-between rounded-t-lg px-4 py-3">
                        <h2 class="text-base-content text-lg font-semibold">Academic Years</h2>
                    </div>

                    <div class="bg-base-100 border-base-300 rounded-b-lg border">

                        <div class="flex flex-col justify-between gap-2 p-4 md:flex-row md:items-center">
                            <div class="join">
                                <input wire:model.live.debounce.250ms='search' type="text"
                                    class="input input-sm input-bordered join-item w-full"
                                    placeholder="Filter academic year..." />
                                <span class="bg-primary join-item flex items-center justify-center px-3">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                            </div>

                            <div class="flex items-center gap-2">
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
                                            wire:click='sortAcademicYear("start_year")'>Start Year <i
                                                @class([
                                                    "fa-solid fa-sort-up" => $order_direction == "desc",
                                                    "fa-solid fa-sort-down" => $order_direction == "asc",
                                                ])></i>
                                        </th>
                                        <th class="cursor-pointer whitespace-nowrap">End Year</th>
                                        <th class="whitespace-nowrap text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($academic_years as $academic_year)
                                        <livewire:components.tableRow.academic-year-tr lazy="on-load" :academic_year_id="$academic_year->academic_year_id"
                                            :start_year="$academic_year->start_year" :end_year="$academic_year->end_year" :key="$academic_year->academic_year_id" />
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-2 px-4 py-2">
                            {{ $academic_years->onEachSide(1)->links(data: ["scrollTo" => false]) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="checkbox" id="add-academic-year-modal" class="modal-toggle" />
    <div id="academic-year-modal" role="dialog" class="modal">
        <form wire:submit='addAcademicYear' class="modal-box sm:w-100 overflow-y-visible sm:max-w-5xl">
            <h3 class="text-lg font-bold">Add Academic Year</h3>

            <div x-data="{ message: '', show: false, timeout: null }"
                x-on:academic-year-created.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
                    show = true; timeout= setTimeout(() => show = false, 2000);">
                <template x-if="show">
                    <div class="alert alert-success my-2">
                        <i class="fa-solid fa-check"></i>
                        <span x-text="message"></span>
                    </div>
                </template>
            </div>

            <div class="mt-2">
                <label class="label after:text-error mb-1 text-sm font-semibold after:content-['*']">Start Year</label>
                <input @class(["input w-full", "input-error" => $errors->has("start_year")]) type="number" wire:model='start_year'>
                @error("start_year")
                    <p class="text-error mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="modal-action">
                <label for="add-academic-year-modal" class="btn-sm btn">Close</label>
                <button class="btn btn-sm btn-primary" wire:loading.attr='disabled'>
                    <i class="fa-solid fa-floppy-disk"></i> Submit
                </button>
            </div>
        </form>
    </div>

    <input x-on:modal-close.window='$el.click()' type="checkbox" id="edit-academic-year-modal" class="modal-toggle" />
    <div id="edit_academic_year_modal" role="dialog" class="modal">
        <form wire:submit='editAcademicYear' class="modal-box w-4/5 max-w-3xl">
            <h3 class="text-lg font-bold">Edit Academic Year</h3>

            <div class="mt-2">
                <label class="label after:text-error mb-1 text-sm font-semibold after:content-['*']">Start Year</label>
                <input @class(["input w-full", "input-error" => $errors->has("start_year")]) type="number" wire:model='start_year'>
                @error("start_year")
                    <p class="text-error mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="modal-action">
                <button wire:click="closeModal" type="button" x-on:academic-year-updated.window="$el.click()"
                    wire:loading.attr='disabled' class="btn-sm btn">Close</button>
                <button wire:loading.attr='disabled' @disabled(empty($start_year) && empty($academic_year_id)) class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Save
                </button>
            </div>
        </form>
    </div>

    <input type="checkbox" id="remove-academic-year" class="modal-toggle" />
    <div x-data='{ id: ""}' id="delete_confirmation_modal" class="modal"
        x-on:remove-academic-year.window="id=$event.detail.id;" x-on:academic-year-removed.window="id=''">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Confirm Deletion</h3>
            <p class="py-2 text-sm">Are you sure you want to delete this account? Graduates within this academic year
                will be affected.</p>
            <div class="modal-action">
                <label for="remove-academic-year" class="btn btn-sm"
                    x-on:academic-year-removed.window="$el.click()">Close</label>

                <button class="btn btn-sm btn-error" wire:loading.attr='disabled'
                    wire:click='deleteAcademicYear(id);'>Yes, Delete
                </button>
            </div>
        </div>
    </div>

    <div x-data="{ message: '', show: false, timeout: null, color: '' }" class="toast toast-end"
        x-on:submission-result.window="show = true; message = event.detail.message; color = event.detail.color; if (timeout) {clearTimeout(timeout)}
    timeout= setTimeout(() => show = false, 2000);">
        <template x-if="show">
            <div class="toast toast-end">
                <div :class="`alert alert-${color}`">
                    <span x-text="message"></span>
                </div>
            </div>
        </template>
    </div>

</div>

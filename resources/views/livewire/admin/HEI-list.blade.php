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
                                    HEI
                                </span>
                            </li>
                        </ul>
                    </div>

                    <label for="add-hei-modal" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i>
                        Add HEI</label>
                </div>

                <div class="mt-2 rounded-lg shadow-md">
                    <div
                        class="bg-secondary text-secondary-content flex items-center justify-between rounded-t-lg px-4 py-3">
                        <h2 class="text-lg font-semibold">HEI List</h2>

                        <a class="badge btn badge-sm badge-primary badge-soft" wire:navigate href="/hei">View HEI
                            Accounts</a>
                    </div>

                    <div class="bg-base-100 rounded-b-lg">
                        <div class="flex flex-col justify-between gap-2 p-4 md:flex-row md:items-center">
                            <div class="join">
                                <input wire:model.live.debounce.250ms='search' type="text"
                                    class="input input-sm input-bordered join-item w-full"
                                    placeholder="Filter HEI..." />
                                <span class="bg-primary join-item flex items-center justify-center px-3">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                            </div>

                            <div class="flex items-center gap-2">
                                <select wire:model.live='only_deleted' class="select select-sm w-full">
                                    <option value="">HEI</option>
                                    <option value="1">Deleted HEI</option>
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
                                        <th class="whitespace-nowrap">HEI Name</th>
                                        <th class="whitespace-nowrap text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($heis as $key => $hei)
                                        <livewire:components.tableRow.hei-table-tr lazy="on-load" :num="$key"
                                            :key="$hei->hei_id" :hei="$hei" />
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-2 px-4 py-2">
                            {{ $heis->onEachSide(1)->links(data: ["scrollTo" => false]) }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <input type="checkbox" id="add-hei-modal" class="modal-toggle" />
    <div id="add_hei_modal" role="dialog" class="modal">
        <form wire:submit='saveHEI' class="modal-box w-4/5 max-w-3xl">
            <h3 class="text-lg font-bold">Add HEI</h3>

            <div x-data="{ message: '', show: false, timeout: null }"
                x-on:hei-created.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
                    show = true; timeout= setTimeout(() => show = false, 2000);">
                <template x-if="show">
                    <div class="alert alert-success my-2">
                        <i class="fa-solid fa-check"></i>
                        <span x-text="message"></span>
                    </div>
                </template>
            </div>

            <div class="mt-3">
                <label class="label after:text-error text-sm font-semibold after:content-['*']">HEI Name</label>
                <input @class(["input w-full", "input-error" => $errors->has("hei_name")]) type="text" wire:model='hei_name'>

                @error("hei_name")
                    <p class="text-error mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="modal-action">
                <label for="add-hei-modal" class="btn-sm btn">Close</label>
                <button class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Submit
                </button>
            </div>
        </form>
    </div>

    <input type="checkbox" id="edit-hei-modal" class="modal-toggle" />
    <div id="edit_hei_modal" role="dialog" class="modal">
        <form wire:submit='editHEI' class="modal-box w-4/5 max-w-3xl">
            <h3 class="text-lg font-bold">Edit HEI</h3>

            <div x-data="{ message: '', show: false, timeout: null }"
                x-on:hei-updated.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
                    show = true; timeout= setTimeout(() => show = false, 2000);">
                <template x-if="show">
                    <div class="alert alert-success my-2">
                        <i class="fa-solid fa-check"></i>
                        <span x-text="message"></span>
                    </div>
                </template>
            </div>

            <div class="mt-3">
                <input wire:model='edit_hei_id' @class(["input w-full", "input-error" => $errors->has("edit_hei_id")]) type="hidden" wire:model='edit_hei_id'>

                <div class="relative w-full">
                    <label class="label after:text-error text-sm font-semibold after:content-['*']">HEI
                        Name</label>
                    <input @disabled(empty($edit_hei_name) && empty($edit_hei_id)) @class([
                        "input w-full",
                        "input-error" => $errors->has("edit_hei_name"),
                    ]) type="text"
                        wire:model='edit_hei_name'>
                    @if (empty($edit_hei_name) && empty($edit_hei_id))
                        <span class="absolute right-5 top-8">
                            <span class="loading loading-spinner loading-sm text-primary"></span>
                        </span>
                    @endif

                    @error("edit_hei_name")
                        <p class="text-error mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="modal-action">
                <label wire:click="updateEditInputs('', '')" for="edit-hei-modal" class="btn-sm btn">Close</label>
                <button @disabled(empty($edit_hei_name) || empty($edit_hei_id)) class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Save
                </button>
            </div>
        </form>
    </div>

    <input type="checkbox" id="restore-hei" class="modal-toggle" />
    <div x-data='{ id: ""}' id="restore_confirmation_modal" class="modal"
        x-on:restore-hei.window="id=$event.detail.id;" x-on:hei-restored.window="id=''">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Confirm Restoration</h3>
            <p class="py-4">Are you sure you want to restore this hei?</p>
            <div class="modal-action">
                <label for="restore-hei" class="btn btn-sm" x-on:hei-restored.window="$el.click()">Close</label>
                <button class="btn btn-sm btn-success" wire:loading.attr='disabled' wire:click='restoreHEI(id);'>
                    Yes, Restore
                </button>
            </div>
        </div>
    </div>

    <input type="checkbox" id="remove-hei" class="modal-toggle" />
    <div x-data='{ id: ""}' id="delete_confirmation_modal" class="modal"
        x-on:remove-hei.window="id=$event.detail.id;" x-on:hei-removed.window="id=''">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Confirm Deletion</h3>
            <p class="py-4">Are you sure you want to delete this hei?</p>
            <div class="modal-action">
                <label for="remove-hei" class="btn btn-sm" x-on:hei-removed.window="$el.click()">Close</label>

                <button class="btn btn-sm btn-error" wire:loading.attr='disabled' wire:click='deleteHEI(id);'>
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>

    <div x-data="{ message: '', show: false, timeout: null }" class="toast toast-end"
        x-on:hei-removed.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
    show = true; timeout= setTimeout(() => show = false, 2000);"
        x-on:hei-restored.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
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

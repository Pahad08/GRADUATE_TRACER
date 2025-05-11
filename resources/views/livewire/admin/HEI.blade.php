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
                        Add HEI Account</label>
                </div>

                <div class="mt-2 rounded-lg shadow-md">

                    <div class="bg-secondary flex items-center justify-between rounded-t-lg px-4 py-3">
                        <h2 class="text-secondary-content text-lg font-semibold">HEI Accounts</h2>

                        <a class="badge btn badge-sm badge-primary badge-soft" wire:navigate href="/hei_list">View
                            HEI</a>
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

                                <div wire:ignore class="h-full w-full">
                                    <select wire:model='selected_hei' id="hei-select" class="select select-sm">
                                        <option class="text-sm" value="">HEI</option>
                                        @foreach (\App\Models\HEI::all() as $hei)
                                            <option value="{{ $hei->hei_id }}">
                                                {{ $hei->hei_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

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
                                        <th class="whitespace-nowrap">Username</th>
                                        <th class="whitespace-nowrap">HEI</th>
                                        <th class="whitespace-nowrap text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accounts as $key => $account)
                                        <livewire:components.tableRow.account-table-tr {{-- lazy="on-load"  --}}
                                            :num="$key" :hei_name="$account->hei->hei_name" :key="$account->user_id" :account="$account" />
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-2 px-4 py-2">
                            {{ $accounts->onEachSide(1)->links(data: ["scrollTo" => false]) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="checkbox" id="add-hei-modal" class="modal-toggle" />
    <div id="add_question_modal" role="dialog" class="modal">
        <form wire:submit='addHeiAccount' class="modal-box w-4/5 max-w-3xl overflow-y-visible">
            <h3 class="text-lg font-bold">Add HEI Account</h3>

            <div x-data="{ message: '', show: false, timeout: null }"
                x-on:account-created.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
                    show = true; timeout= setTimeout(() => show = false, 2000);">
                <template x-if="show">
                    <div class="alert alert-success my-2">
                        <i class="fa-solid fa-check"></i>
                        <span x-text="message"></span>
                    </div>
                </template>
            </div>

            <div class="mt-2">
                <label class="label after:text-error mb-1 text-sm font-semibold after:content-['*']">Username</label>
                <input @class(["input w-full", "input-error" => $errors->has("username")]) type="text" wire:model='username'>

                @error("username")
                    <p class="text-error mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-3">
                <label class="label after:text-error mb-1 text-sm font-semibold after:content-['*']">HEI</label>

                <div wire:ignore class="h-full w-full">
                    <select @class([
                        "w-full",
                        "select-error" => $errors->has("selected_form_hei"),
                    ]) wire:model='selected_form_hei' id="hei-form-select">
                        <option></option>
                        @foreach (\App\Models\HEI::all() as $hei)
                            <option value="{{ $hei->hei_id }}">
                                {{ $hei->hei_name }}</option>
                        @endforeach
                    </select>
                </div>

                @error("selected_form_hei")
                    <p class="text-error mt-1 text-sm">{{ $message }}</p>
                @enderror
                {{-- 
                <div class="relative mt-1 w-full" x-data="{ open: false }"
                    @click.outside="if(open) {open = false; $wire.clearHEISelect()}">
                    <input x-on:focus="open = true" wire:model.live.debounce.300ms="hei_form_search" type="text"
                        placeholder="Select HEI" class="input w-full" />

                    @if (!empty($hei_form_results))
                        <ul
                            class="border-base-300 z-999 absolute mt-1 max-h-60 w-full overflow-y-auto rounded-md border bg-white shadow-md">
                            @forelse($hei_form_results as $hei)
                                <li wire:click="selecFormHei({{ $hei->hei_id }})"
                                    class="cursor-pointer p-2 hover:bg-purple-100">
                                    {{ $hei->hei_name }}
                                </li>
                            @empty
                                <li class="p-2 text-sm text-gray-500">No hei found.</li>
                            @endforelse
                        </ul>
                    @endif
                </div> --}}
            </div>

            <div class="modal-action">
                <label for="add-hei-modal" class="btn-sm btn" x-on:graduate-removed.window="$el.click()">Close</label>
                <button class="btn btn-sm btn-primary" wire:loading.attr='disabled'>
                    <i class="fa-solid fa-floppy-disk"></i> Submit
                </button>
            </div>
        </form>
    </div>

    <input type="checkbox" id="edit-account-modal" class="modal-toggle" />
    <div id="edit_account_modal" role="dialog" class="modal">
        <form wire:submit='editHEIAccount' class="modal-box w-4/5 max-w-3xl">
            <h3 class="text-lg font-bold">Edit HEI Account</h3>

            <div x-data="{ message: '', show: false, timeout: null }"
                x-on:account-updated.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
                    show = true; timeout= setTimeout(() => show = false, 2000);">
                <template x-if="show">
                    <div class="alert alert-success my-2">
                        <i class="fa-solid fa-check"></i>
                        <span x-text="message"></span>
                    </div>
                </template>
            </div>

            <div class="mt-3">
                <div class="relative w-full">
                    <label class="label after:text-error text-sm font-semibold after:content-['*']">Username</label>
                    <input @disabled(empty($edit_username) && empty($edit_account_id)) @class([
                        "input w-full",
                        "input-error" => $errors->has("edit_username"),
                    ]) type="text"
                        wire:model='edit_username'>
                    @if (empty($edit_username) && empty($edit_account_id))
                        <span class="absolute right-5 top-8">
                            <span class="loading loading-spinner loading-sm text-primary"></span>
                        </span>
                    @endif

                    @error("edit_username")
                        <p class="text-error mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative mt-3 w-full">
                    <label class="label after:text-error text-sm font-semibold after:content-['*']">Password</label>
                    <input @class(["input w-full", "input-error" => $errors->has("password")]) type="password" wire:model='password'>

                    @error("password")
                        <p class="text-error mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="modal-action">
                <label wire:click="updateEditInputs('', '')" for="edit-account-modal"
                    class="btn-sm btn">Close</label>
                <button @disabled(empty($edit_username) && empty($edit_account_id)) class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Save
                </button>
            </div>
        </form>
    </div>

    <input type="checkbox" id="remove-account" class="modal-toggle" />
    <div x-data='{ id: ""}' id="delete_confirmation_modal" class="modal"
        x-on:remove-account.window="id=$event.detail.id;" x-on:account-removed.window="id=''">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Confirm Deletion</h3>
            <p class="py-4">Are you sure you want to delete this account?</p>
            <div class="modal-action">
                <label for="remove-account" class="btn btn-sm"
                    x-on:account-removed.window="$el.click()">Close</label>

                <button class="btn btn-sm btn-error" wire:loading.attr='disabled' wire:click='deleteAccount(id);'>
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>

    <input type="checkbox" id="restore-account" class="modal-toggle" />
    <div x-data='{ id: ""}' id="restore_confirmation_modal" class="modal"
        x-on:restore-account.window="id=$event.detail.id;" x-on:account-restored.window="id=''">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Confirm Restoration</h3>
            <p class="py-4">Are you sure you want to restore this account?</p>
            <div class="modal-action">
                <label for="restore-account" class="btn btn-sm"
                    x-on:account-restored.window="$el.click()">Close</label>
                <button class="btn btn-sm btn-success" wire:loading.attr='disabled' wire:click='restoreAccount(id);'>
                    Yes, Restore
                </button>
            </div>
        </div>
    </div>

    <div x-data="{ message: '', show: false, timeout: null }" class="toast toast-end"
        x-on:account-removed.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
    show = true; timeout= setTimeout(() => show = false, 2000);"
        x-on:account-restored.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
    show = true; timeout= setTimeout(() => show = false, 2000);">
        <template x-if="show">
            <div class="toast toast-end">
                <div class="alert alert-success">
                    <span x-text="message"></span>
                </div>
            </div>
        </template>
    </div>

    <div x-data="{ message: '', show: false, timeout: null }" class="toast toast-end"
        x-on:account-delete-fail.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
    show = true; timeout= setTimeout(() => show = false, 2000);">
        <template x-if="show">
            <div class="toast toast-end">
                <div class="alert alert-error">
                    <span x-text="message"></span>
                </div>
            </div>
        </template>
    </div>

    @assets
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endassets

    @script
        <script>
            $('#hei-select').select2();
            $('#hei-form-select').select2({
                placeholder: "Select a HEI",
            });

            $('#hei-select').on('change', function() {
                $wire.set('selected_hei', $(this).val());
            });

            $('#hei-form-select').on('change', function() {
                $wire.set('selected_form_hei', $(this).val());
            });

            $wire.on('account-created', () => {
                $('#hei-form-select').val(null).trigger('change');
            });
        </script>
    @endscript
</div>

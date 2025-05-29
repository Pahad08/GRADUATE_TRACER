<div id="root" x-data="{ isAddModalOpen: false }">

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

                    <button class="btn btn-primary btn-sm" x-on:click="isAddModalOpen = true; $dispatch('fetch-hei')"><i
                            class="fa-solid fa-plus"></i>
                        Add HEI Account</button>
                </div>

                <div class="mt-2 rounded-lg shadow-md">
                    <div class="bg-base-300 flex items-center justify-between rounded-t-lg px-4 py-3">
                        <h2 class="text-base-content text-lg font-semibold">HEI Accounts</h2>
                    </div>

                    <div class="bg-base-100 border-base-300 rounded-b-lg border">
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
                                        <th class="whitespace-nowrap">Username</th>
                                        <th class="whitespace-nowrap">HEI</th>
                                        <th class="whitespace-nowrap text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accounts as $key => $account)
                                        <livewire:components.tableRow.account-table-tr lazy="on-load" :num="$key"
                                            :user_id="$account->user_id" :username="$account->username" :inst_name="$account->inst_name" :key="$account->user_id" />
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

    <div id="add_hei_modal" role="dialog" class="modal" :class="isAddModalOpen ? 'modal-open' : ''">
        <form wire:submit='addHeiAccount' class="modal-box w-4/5 max-w-3xl overflow-y-visible" x-data="{
            open: false,
            search: '',
            results: {},
            get filtered() {
                return Object.entries(this.results).filter(([_, hei]) =>
                    this.search === '' || hei.toLowerCase().includes(this.search.toLowerCase())
                );
            },
            reset() {
                this.open = false;
            }
        }"
            x-on:fetch-hei.window="if(Object.keys(results).length === 0){
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
                
                        results = data;
                    } catch (error) {
                        console.error('Fetch failed', error);
                        results = { error: 'Error fetching data' };
                    }
                })()
                    }"
            @click.outside="if (open) reset()" x-on:account-created.window="search = ''">
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

            <div class="mt-3">
                <label class="label after:text-error mb-1 text-sm font-semibold after:content-['*']">HEI</label>

                <div class="relative w-full">
                    <div class="relative">
                        <input x-on:focus="open = true" x-model="search" :disabled="Object.keys(results).length === 0"
                            type="text" class="input w-full bg-white" />
                        <span x-show="Object.keys(results).length === 0"
                            class="loading loading-spinner loading-md absolute right-4 top-2"></span>
                    </div>

                    <ul x-show="open" x-transition
                        class="border-base-300 absolute z-50 mt-1 max-h-60 w-full overflow-y-auto rounded-md border bg-white shadow-md">
                        <template x-if="filtered.length > 0">
                            <template x-for="[hei_key, hei] in filtered" :key="hei_key">
                                <li x-on:click="open = false; $wire.set('inst_code', hei_key,false); $wire.set('inst_name', hei, false); search = hei"
                                    class="hover:bg-primary hover:text-base-100 cursor-pointer p-3" x-text="hei"></li>
                            </template>
                        </template>
                        <template x-if="filtered.length === 0">
                            <li class="text-error p-3">No results found.</li>
                        </template>
                    </ul>
                </div>

                @error("inst_code")
                    <p class="text-error mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="modal-action">
                <button class="btn-sm btn" type="button" x-on:click="isAddModalOpen = false;"
                    x-on:graduate-removed.window="isAddModalOpen = false;">Close</label>
                    <button class="btn btn-sm btn-primary" wire:loading.attr='disabled'
                        :disabled="Object.keys(results).length === 0">
                        <i class="fa-solid fa-floppy-disk"></i> Submit
                    </button>
            </div>
        </form>
    </div>

    <input x-on:modal-close.window='$el.click()' type="checkbox" id="edit-account-modal" class="modal-toggle" />
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
                <button wire:click="closeModal" type="button" wire:loading.attr='disabled'
                    class="btn-sm btn">Close</button>
                <button wire:loading.attr='disabled' @disabled(empty($edit_username) && empty($edit_account_id)) class="btn btn-sm btn-primary">
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
</div>

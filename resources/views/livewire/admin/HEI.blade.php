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

                    <label for="add-hei-modal" class="btn btn-primary btn-sm text-white"><i
                            class="fa-solid fa-plus"></i>
                        Add HEI</label>
                </div>

                <div class="mt-2 rounded-lg shadow-md">
                    <div class="bg-secondary text-base-100 flex items-center justify-between rounded-t-lg px-4 py-3">
                        <h2 class="text-lg font-semibold">HEI List</h2>

                        <a class="badge btn badge-sm badge-primary badge-soft">View Universities</a>
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
                                    <select id="university-select" class="select select-sm">
                                        <option value="" class="text-sm">University</option>
                                        @foreach (\App\Models\University::all() as $university)
                                            <option value="{{ $university->university_id }}">
                                                {{ $university->university_name }}</option>
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
                                        <th class="whitespace-nowrap">Password</th>
                                        <th class="whitespace-nowrap">University</th>
                                        <th class="whitespace-nowrap text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($graduates as $key => $graduate)
                                        <livewire:components.graduate-table-tr lazy="on-load" :num="$key"
                                            :key="$graduate->graduate_id" :graduate="$graduate" />
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>

                        {{-- <div class="mt-2 px-4 py-2">
                            {{ $graduates->onEachSide(1)->links(data: ["scrollTo" => false]) }}
                        </div> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <input type="checkbox" id="add-hei-modal" class="modal-toggle" />
    <div id="add_question_modal" role="dialog" class="modal">
        <div class="modal-box w-4/5 max-w-3xl">
            <h3 class="text-lg font-bold">Add HEI</h3>

            <div class="modal-action">
                <label for="add-hei-modal" class="btn-sm btn" x-on:graduate-removed.window="$el.click()">Close</label>
                <button class="btn btn-sm btn-primary" wire:loading.attr='disabled' wire:click='deleteGraduate(id);'>
                    Submit
                </button>
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
                <label for="remove-graduate" class="btn" x-on:graduate-removed.window="$el.click()">Close</label>

                <button class="btn btn-error" wire:loading.attr='disabled' wire:click='deleteGraduate(id);'>
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>

</div>

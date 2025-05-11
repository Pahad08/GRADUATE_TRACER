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
                                <a wire:navigate href="/graduates">
                                    <i class="fa-solid fa-user-graduate"></i>
                                    Graduates
                                </a>
                            </li>
                            <li>
                                <span class="inline-flex items-center gap-2">
                                    <i class="fa-solid fa-clipboard-list"></i>
                                    Manage questions
                                </span>
                            </li>
                        </ul>
                    </div>

                    <label for="add-question-modal" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i>
                        Add question</label>
                </div>

                <div class="bg-secondary mt-2 w-full overflow-x-auto whitespace-nowrap rounded-t px-3 py-2">
                    <div>
                        @foreach ($sections as $key => $section)
                            <a role="tab" class="tab font-semibold"
                                :class="{
                                    'text-base-100!': active == '{{ $key }}',
                                }"
                                x-on:click="active = '{{ $key }}'" wire:key='{{ $key }}'><i
                                    class="fa-solid {{ $section["icon"] }}"></i>&nbsp;{{ $section["title"] }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="border-1 border-base-300 rounded-b bg-white shadow-md">
                    <div class="overflow-x-auto">
                        @foreach ($sections as $key => $sec)
                            <div class="card" wire:cloak x-show="active === '{{ $key }}'"
                                wire:key='{{ $key }}'>
                                <div class="card-body">
                                    <livewire:dynamic-component :is="$key" :key="$key" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ message: '', show: false, timeout: null }" class="toast toast-end"
        x-on:label-visibility-changed.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
        show = true; timeout= setTimeout(() => show = false, 2000);"
        x-on:order-changed.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
        show = true; timeout= setTimeout(() => show = false, 2000);"
        x-on:question-removed.window="message = 'Question removed!'; if (timeout) {clearTimeout(timeout)} 
        show = true; timeout= setTimeout(() => show = false, 2000);">
        <template x-if="show">
            <div class="toast toast-end">
                <div class="alert alert-success">
                    <span x-text="message"></span>
                </div>
            </div>
        </template>
    </div>

    <input type="checkbox" id="add-question-modal" class="modal-toggle" />
    <div id="add_question_modal" role="dialog" class="modal">
        <div class="modal-box w-4/5 max-w-3xl">
            <h3 class="text-lg font-bold">Add Custom Question</h3>

            <div x-data="{ message: '', show: false, timeout: null }"
                x-on:question-created.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
                    show = true; timeout= setTimeout(() => show = false, 2000);">
                <template x-if="show">
                    <div class="alert alert-success my-2">
                        <i class="fa-solid fa-check"></i>
                        <span x-text="message"></span>
                    </div>
                </template>
            </div>

            <div class="mt-3 grid grid-cols-2 gap-4" x-data="{ type: '' }">
                <div>
                    <label class="label after:text-error text-sm font-semibold after:content-['*']">Label</label>
                    <input @class(["input w-full", "input-error" => $errors->has("label")]) type="text" wire:model='label'>
                </div>

                <div>
                    <label class="label after:text-error text-sm font-semibold after:content-['*']">Section</label>
                    <select @class(["select w-full", "select-error" => $errors->has("section")]) wire:model='section'>
                        <option value="" selected>Select Section</option>
                        <option value="GENERAL_INFORMATION">General Information</option>
                        <option value="EDUCATIONAL_BACKGROUND">Educational Background</option>
                        <option value="TRAININGS_STUDIES">Training and Advanced Studies</option>
                        <option value="EMPLOYMENT_DATA">Employment Data</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="label after:text-error text-sm font-semibold after:content-['*']">Type</label>
                    <div class="filter">
                        <input class="btn filter-reset" type="radio" x-model="type" value="" name="type"
                            aria-label="All" />
                        <input class="btn" type="radio" name="type" x-model="type" wire:model='type'
                            value="text" aria-label="Text" />
                        <input class="btn" type="radio" name="type" x-model="type" wire:model='type'
                            value="number" aria-label="Number" />
                        <input class="btn" type="radio" name="type" x-model="type" wire:model='type'
                            value="date" aria-label="Date" />
                        <input class="btn" type="radio" name="type" x-model="type" wire:model='type'
                            value="checkbox" aria-label="Checkbox" />
                        <input class="btn" type="radio" name="type" x-model="type" wire:model='type'
                            value="radio" aria-label="Radio" />
                        <input class="btn" type="radio" name="type" x-model="type" wire:model='type'
                            value="select" aria-label="Select" />
                    </div>

                    @error("type")
                        <p class="text-error mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <template x-if="(type === 'radio' || type === 'checkbox' || type === 'select') && type !== ''">
                    <div class="col-span-2">
                        <div class="grid grid-cols-3 items-end gap-y-2 md:grid-cols-3">
                            @foreach ($option_inputs as $key => $value)
                                <div class="col-span-1" wire:key='{{ $key }}'>
                                    <input type="text" wire:model='option_inputs.{{ $key }}.option_text'
                                        @class([
                                            "input w-full md:rounded-none",
                                            "input-error" => $errors->has("option_inputs." . $key . ".option_text"),
                                        ]) placeholder="Option text">
                                </div>

                                <div class="col-span-1">
                                    <input type="text" wire:model='option_inputs.{{ $key }}.option_value'
                                        @class([
                                            "input w-full md:rounded-none",
                                            "input-error" => $errors->has("option_inputs." . $key . ".option_value"),
                                        ]) placeholder="Value">
                                </div>

                                <div class="col-span-1">
                                    @if ($loop->first)
                                        <button class="btn btn-primary w-full md:rounded-none"
                                            wire:click='addOptionvalue' wire:loading.attr="disabled" type="button">
                                            Add Option
                                        </button>
                                    @else
                                        <button class="btn btn-error w-full md:rounded-none"
                                            wire:click='removeOptionvalue({{ $key }})'
                                            wire:loading.attr="disabled" type="button">
                                            Remove option
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </template>

            </div>

            <div class="modal-action">
                <label class="btn btn-sm" for="add-question-modal">Close</label>
                <button class="btn btn-primary btn-sm" wire:click='saveCustomQuestion' wire:loading.attr="disabled">
                    <i class="fa-solid fa-floppy-disk"></i> Submit</button>
            </div>
        </div>
    </div>

    <input type="checkbox" id="remove-question" x-on:question-removed.window="$el.click();" class="modal-toggle" />
    <div x-data='{ key:""}' id="confirmation_modal" class="modal"
        x-on:set-question-to-remove.window="key = event.detail;">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Confirm Deletion</h3>
            <p class="py-4">Are you sure you want to delete this question?</p>
            <div class="modal-action">
                <label for="remove-question" class="btn">Close</label>

                <button class="btn btn-error text-white" wire:loading.attr='disabled'
                    wire:click='removeQuestion(key)'>
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

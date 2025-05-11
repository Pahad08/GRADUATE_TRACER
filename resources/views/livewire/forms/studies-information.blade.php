<div class="rounded-none px-3">
    <div class="card lg:w-250 md:w-230 mx-auto my-5 max-w-full bg-white">
        <div class="card-body rounded-lg shadow-md">
            <div class="grid grid-cols-1">
                @foreach ($this->questionVisibility as $question)
                    @switch($question->question_key)
                        @case("TS-trainings")
                            <div wire:key='{{ $question->question_key }}'>

                                <p class="font-medium">Please list down all professional or work-related training program(s)
                                    including advance studies you have attended after college.</p>

                                <div class="grid grid-cols-1">
                                    @foreach ($this->trainings as $key => $row)
                                        <div class="{{ $loop->first ? "mt-2" : "" }} grid w-full grid-cols-1 items-end gap-y-2 md:grid-cols-4"
                                            wire:key="{{ "trainings-" . $key }}">

                                            <div class="col-span-1">
                                                @if ($loop->first)
                                                    <label class="text-neutral mb-2 block text-sm font-semibold">
                                                        Title of Training
                                                    </label>
                                                @endif
                                                <input type="text" wire:model="trainings.{{ $key }}.training_name"
                                                    class="input {{ !$loop->first ? "mt-2" : "" }} @error("trainings." . $key . ".training_name") input-error @enderror w-full md:rounded-none">
                                            </div>

                                            <div class="col-span-1">
                                                @if ($loop->first)
                                                    <label class="text-neutral mb-2 block text-sm font-semibold">
                                                        Duration and Credits Earned
                                                    </label>
                                                @endif
                                                <input type="text"
                                                    wire:model="trainings.{{ $key }}.duration_and_credits_earned"
                                                    class="input {{ !$loop->first ? "mt-2" : "" }} @error("trainings." . $key . ".duration_and_credits_earned") input-error @enderror w-full md:rounded-none md:border-x-0">
                                            </div>

                                            <div class="col-span-1">
                                                @if ($loop->first)
                                                    <label class="text-neutral mb-2 block text-sm font-semibold">
                                                        Name of Training Institution
                                                    </label>
                                                @endif
                                                <input type="text"
                                                    wire:model="trainings.{{ $key }}.training_institution"
                                                    class="input {{ !$loop->first ? "mt-2" : "" }} @error("trainings." . $key . ".training_institution") input-error @enderror w-full md:rounded-none">
                                            </div>

                                            <div>
                                                @if ($loop->first)
                                                    <button class="btn btn-secondary mt-2 w-full md:rounded-none" type="button"
                                                        wire:click="addTrainingRow" wire:loading.attr="disabled">
                                                        <span wire:loading wire:target="addTrainingRow"
                                                            class="loading loading-spinner"></span>
                                                        <i class="fa-solid fa-plus" wire:target="addTrainingRow"
                                                            wire:loading.remove></i>
                                                    </button>
                                                @else
                                                    <button wire:loading.attr="disabled"
                                                        wire:target='removeTrainingRow({{ $key }})'
                                                        class="btn btn-error mt-2 w-full rounded-none" type="button"
                                                        wire:click="removeTrainingRow({{ $key }})">
                                                        <span wire:loading wire:target="removeTrainingRow({{ $key }})"
                                                            class="loading loading-spinner"></span>
                                                        <i class="fa-solid fa-trash"
                                                            wire:target="removeTrainingRow({{ $key }})"
                                                            wire:loading.remove></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="divider"></div>
                            </div>
                        @break

                        @case("TS-reason_for_studies")
                            <div class="mt-2" wire:key='{{ $question->question_key }}'>
                                <label
                                    class="text-neutral after:text-error mb-2 block text-sm font-semibold after:content-['*']">What
                                    made you pursue advance
                                    studies? </label>
                                <div class="md:grid-cols-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" class="checkbox" value="For promotion"
                                            wire:model="reasons_for_study.checkboxes">
                                        <span class="ml-2">For promotion</span>
                                    </label>

                                    <label class="mt-3 flex items-center">
                                        <input type="checkbox" class="checkbox" value="For professional development"
                                            wire:model="reasons_for_study.checkboxes">
                                        <span class="ml-2">For professional development</span>
                                    </label>

                                    <input type="text" placeholder="Others, please specify"
                                        wire:model="reasons_for_study.input" class="input mt-3 w-full md:col-span-2">
                                </div>

                                @error("reasons_for_study.input")
                                    <div class="mt-1">
                                        <p class="text-error">
                                            {{ $message }}
                                        </p>
                                    </div>
                                @enderror

                                @error("reasons_for_study.checkboxes")
                                    <div class="mt-1">
                                        <p class="text-error">
                                            {{ $message }}
                                        </p>
                                    </div>
                                @enderror
                            </div>
                        @break

                        @default
                            @if ($question->question)
                                @php
                                    $label = ucfirst($question->question->label);
                                    $field_key = str_replace(" ", "_", $question->question->label);
                                    $options = $question->question->questionOption;
                                @endphp

                                <div wire:key='{{ $question->question_key }}'>
                                    <div class="divider"></div>
                                    <label
                                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                        {{ $label }}
                                    </label>

                                    @if ($question->question->has_child)
                                        @switch($question->question->type)
                                            @case("radio")
                                                <div class="flex items-center gap-4">
                                                    @foreach ($options as $item)
                                                        <label class="flex items-center" wire:key="{{ $item->question_option_id }}">
                                                            <input type="radio" wire:model="custom_questions.{{ $field_key }}"
                                                                class="radio {{ $errors->has("custom_questions." . $field_key) ? "radio-error" : "" }}"
                                                                value="{{ $item->option_value }}">
                                                            <span class="ml-2">{{ $item->option_text }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @break

                                            @case("checkbox")
                                                <div class="flex flex-wrap gap-4">
                                                    @foreach ($options as $key => $option)
                                                        <label class="mt-2 flex items-center" wire:key="{{ $key }}">
                                                            <input type="checkbox" class="checkbox" value="{{ $option->option_value }}"
                                                                wire:model="custom_questions.{{ $field_key }}">
                                                            <span class="ml-2">{{ $option->option_text }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                                @error("custom_questions.$field_key")
                                                    <p class="text-error mt-1">Select at least one.</p>
                                                @enderror
                                            @break

                                            @default
                                                <select
                                                    class="select {{ $errors->has("custom_questions." . $field_key) ? "select-error" : "" }} w-full"
                                                    wire:model="custom_questions.{{ $field_key }}">
                                                    <option>Select {{ $label }}</option>
                                                    @foreach ($options as $key => $option)
                                                        <option value="{{ $option->option_value }}" wire:key="{{ $key }}">
                                                            {{ ucfirst($option->option_text) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error("custom_questions.$field_key")
                                                    <p class="text-error mt-1">Select at least one.</p>
                                                @enderror
                                        @endswitch
                                    @else
                                        <input type="{{ $question->question->type }}"
                                            class="input {{ $errors->has("custom_questions." . $field_key) ? "input-error" : "" }} w-full"
                                            wire:model="custom_questions.{{ $field_key }}">
                                    @endif
                                </div>
                            @endif
                        @endswitch
                    @endforeach
                </div>
            </div>
        </div>
    </div>

<div class="rounded-none px-3">
    <div class="card lg:w-250 md:w-230 mx-auto my-5 max-w-full">
        <div class="card-body bg-base-200 border-base-300 rounded-lg border shadow-md">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach ($this->questionVisibility as $question)
                    @switch($question->question_key)
                        @case("GI-f_name")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">First
                                    Name </label>
                                <input type="text" @class(["input w-full", "input-error" => $errors->has("form.f_name")]) wire:model="form.f_name">
                                @if ($errors->has("form.f_name"))
                                    <span class="text-error mt-2 text-sm">{{ $errors->first("form.f_name") }}</span>
                                @endif
                            </div>
                        @break

                        @case("GI-l_name")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Last
                                    Name </label>
                                <input type="text" class="input @error("form.l_name") input-error @enderror w-full"
                                    wire:model="form.l_name">
                                @if ($errors->has("form.l_name"))
                                    <span class="text-error mt-2 text-sm">{{ $errors->first("form.l_name") }}</span>
                                @endif
                            </div>
                        @break

                        @case("GI-name_extension")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold">Name
                                    Extension (eg., Jr., Sr.) </label>
                                <input type="text" class="input @error("form.name_extension") input-error @enderror w-full"
                                    wire:model="form.name_extension">
                                @if ($errors->has("form.name_extension"))
                                    <span class="text-error mt-2 text-sm">{{ $errors->first("form.name_extension") }}</span>
                                @endif
                            </div>
                        @break

                        @case("GI-permanent_address")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Permanent
                                    Address </label>
                                <input type="text"
                                    class="input @error("form.permanent_address") input-error @enderror w-full"
                                    wire:model="form.permanent_address">
                                @if ($errors->has("form.permanent_address"))
                                    <span class="text-error mt-2 text-sm">{{ $errors->first("form.permanent_address") }}</span>
                                @endif
                            </div>
                        @break

                        @case("GI-email")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">E-mail
                                    Address </label>
                                <input type="email" class="input @error("form.email_address") input-error @enderror w-full"
                                    wire:model="form.email_address">
                                @if ($errors->has("form.email_address"))
                                    <span class="text-error mt-2 text-sm">{{ $errors->first("form.email_address") }}</span>
                                @endif
                            </div>
                        @break

                        @case("GI-contact_number")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Contact
                                    Number </label>
                                <input type="text" class="input @error("form.contact_number") input-error @enderror w-full"
                                    wire:model="form.contact_number">
                                @if ($errors->has("form.contact_number"))
                                    <span class="text-error mt-2 text-sm">{{ $errors->first("form.contact_number") }}</span>
                                @endif
                            </div>
                        @break

                        @case("GI-sex")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Sex
                                </label>
                                <div class="options-center flex gap-4">
                                    <label class="flex items-center">
                                        <input type="radio" wire:model="form.sex"
                                            class="radio @error("form.sex") radio-error @enderror border-base-300 bg-white"
                                            value="male">
                                        <span class="ml-2">Male</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" wire:model="form.sex"
                                            class="radio @error("form.sex") radio-error @enderror border-base-300 bg-white"
                                            value="female">
                                        <span class="ml-2">Female</span>
                                    </label>
                                </div>
                                @if ($errors->has("form.sex"))
                                    <span class="text-error mt-2 text-sm">{{ $errors->first("form.sex") }}</span>
                                @endif
                            </div>
                        @break

                        @case("GI-civil_status")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Civil
                                    Status </label>
                                <select class="select @error("form.civil_status") select-error @enderror w-full"
                                    wire:model="form.civil_status">
                                    <option>Select a civil status</option>
                                    @foreach ($civil_status_selection as $key => $selection)
                                        <option value="{{ $selection }}" wire:key='{{ "selection-" . $key }}'>
                                            {{ ucfirst($selection) }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has("form.civil_status"))
                                    <span class="text-error mt-2 text-sm">{{ $errors->first("form.civil_status") }}</span>
                                @endif
                            </div>
                        @break

                        @case("GI-birthdate")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Birthday
                                </label>
                                <input type="date"
                                    class="input date-input @error("form.birthdate") input-error @enderror w-full"
                                    wire:model="form.birthdate">

                                @if ($errors->has("form.birthdate"))
                                    <span class="text-error mt-2 text-sm">{{ $errors->first("form.birthdate") }}</span>
                                @endif
                            </div>
                        @break

                        @case("GI-region_of_origin")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Region
                                    of Origin </label>
                                <select class="select @error("form.region") select-error @enderror w-full"
                                    wire:model="form.region">
                                    <option value="REGION 12">Region 12</option>
                                </select>
                                @if ($errors->has("form.region"))
                                    <span class="text-error mt-2 text-sm">{{ $errors->first("form.region") }}</span>
                                @endif
                            </div>
                        @break

                        @case("GI-province")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Province
                                </label>
                                <select class="select @error("form.province") select-error @enderror w-full"
                                    wire:model="form.province">
                                    <option disabled value="">Select a province</option>
                                    @foreach ($provinces as $key => $province)
                                        <option wire:key="{{ $key }}" value="{{ $province }}">
                                            {{ $province }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has("form.province"))
                                    <span class="text-error mt-2 text-sm">{{ $errors->first("form.province") }}</span>
                                @endif
                            </div>
                        @break

                        @case("GI-location_of_residence")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Location
                                    of Residence </label>
                                <div class="mb-2 flex gap-4">
                                    <label class="flex items-center">
                                        <input type="radio" wire:model="form.location_of_residence"
                                            class="radio @error("form.location_of_residence") radio-error @enderror border-base-300 bg-white"
                                            value="city">
                                        <span class="ml-2">City</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" wire:model="form.location_of_residence"
                                            class="radio @error("form.location_of_residence") radio-error @enderror border-base-300 bg-white"
                                            value="municipality">
                                        <span class="ml-2">Municipality</span>
                                    </label>
                                </div>
                                @if ($errors->has("form.location_of_residence"))
                                    <span
                                        class="text-error mt-2 text-sm">{{ $errors->first("form.location_of_residence") }}</span>
                                @endif
                            </div>
                        @break

                        @default
                            @if ($question->question)
                                @php
                                    $label = ucfirst($question->question->label);
                                    $fieldKey = str_replace(" ", "_", $question->question->label);
                                    $options = $question->question->questionOption;
                                @endphp

                                <div class="mt-2">
                                    <label
                                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                        {{ $label }}
                                    </label>

                                    @if ($question->question->has_child)
                                        @if ($question->question->type === "radio")
                                            <div>
                                                <div class="flex items-center gap-4">
                                                    @foreach ($options as $item)
                                                        <label class="flex items-center"
                                                            wire:key="{{ $item->question_option_id }}">
                                                            <input type="radio"
                                                                wire:model="form.custom_questions.{{ $fieldKey }}"
                                                                class="radio border-base-300 {{ $errors->has("form.custom_questions." . $fieldKey) ? "radio-error" : "" }} bg-white"
                                                                value="{{ $item->option_value }}">
                                                            <span class="ml-2">{{ $item->option_text }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                                @if ($errors->has("form.custom_questions.$fieldKey"))
                                                    <p class="text-error mt-1">
                                                        {{ $errors->first("form.custom_questions.$fieldKey") }}</p>
                                                @endif
                                            </div>
                                        @elseif($question->question->type === "checkbox")
                                            <div>
                                                <div class="flex flex-wrap gap-4">
                                                    @foreach ($options as $key => $option)
                                                        <label class="mt-2 flex items-center" wire:key="{{ $key }}">
                                                            <input type="checkbox" class="checkbox border-base-300 bg-white"
                                                                value="{{ $option->option_value }}"
                                                                wire:model="form.custom_questions.{{ $fieldKey }}">
                                                            <span class="ml-2">{{ $option->option_text }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                                @if ($errors->has("form.custom_questions.$fieldKey"))
                                                    <p class="text-error mt-1">
                                                        {{ $errors->first("form.custom_questions.$fieldKey") }}</p>
                                                @endif
                                            </div>
                                        @else
                                            <div>
                                                <select
                                                    class="select border-base-300 {{ $errors->has("form.custom_questions.$fieldKey") ? "select-error" : "" }} w-full bg-white"
                                                    wire:model="form.custom_questions.{{ $fieldKey }}">
                                                    <option>Select {{ $label }}</option>
                                                    @foreach ($options as $key => $option)
                                                        <option value="{{ $option->option_value }}"
                                                            wire:key="{{ $key }}">
                                                            {{ ucfirst($option->option_text) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has("form.custom_questions.$fieldKey"))
                                                    <p class="text-error mt-1">
                                                        {{ $errors->first("form.custom_questions.$fieldKey") }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        <div>
                                            <input type="{{ $question->question->type }}" @class([
                                                "input w-full ",
                                                "input-error" => $errors->has("form.custom_questions.$fieldKey"),
                                            ])
                                                wire:model="form.custom_questions.{{ $fieldKey }}">
                                            @if ($errors->has("form.custom_questions.$fieldKey"))
                                                <span
                                                    class="text-error mt-2 text-sm">{{ $errors->first("form.custom_questions.$fieldKey") }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif
                    @endswitch
                @endforeach
            </div>

            <div class="mt-2 flex justify-end">
                <button type="button" class="btn btn-primary"
                    x-on:click="activeTab = 'tracer-components.educational-background';window.scrollTo({ top: 0, behavior: 'smooth' })">Next
                    <i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>

<div class="rounded-none px-3">
    <div class="card lg:w-250 md:w-230 mx-auto my-5 max-w-full">
        <div class="card-body rounded-lg bg-white shadow-md">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach ($this->questionVisibility as $question)
                    @switch($question->question_key)
                        @case("GI-f_name")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">First
                                    Name </label>
                                <input type="text" @class(["input w-full", "input-error" => $errors->has("form.f_name")]) wire:model="form.f_name">

                            </div>
                        @break

                        @case("GI-l_name")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Last
                                    Name </label>
                                <input type="text" class="input @error("form.l_name") input-error @enderror w-full"
                                    wire:model="form.l_name">
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
                            </div>
                        @break

                        @case("GI-email")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">E-mail
                                    Address </label>
                                <input type="email" class="input @error("form.email_address") input-error @enderror w-full"
                                    wire:model="form.email_address">
                            </div>
                        @break

                        @case("GI-contact_number")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Contact
                                    Number </label>
                                <input type="number" class="input @error("form.contact_number") input-error @enderror w-full"
                                    wire:model="form.contact_number">
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
                                            class="radio @error("form.sex") radio-error @enderror" value="male">
                                        <span class="ml-2">Male</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" wire:model="form.sex"
                                            class="radio @error("form.sex") radio-error @enderror" value="female">
                                        <span class="ml-2">Female</span>
                                    </label>
                                </div>
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
                            </div>
                        @break

                        @case("GI-region_of_origin")
                            <div>
                                <label
                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Region
                                    of Origin </label>
                                <select class="select @error("form.region") select-error @enderror w-full"
                                    wire:model="form.region">
                                    <option disabled value="">Select a Region</option>
                                    @foreach (\App\Models\Region::all() as $region)
                                        <option wire:key="{{ $region->region_id }}" value="{{ $region->region_id }}">
                                            {{ $region->region_name }}</option>
                                    @endforeach
                                </select>
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
                                    @foreach (\App\Models\Province::all() as $province)
                                        <option wire:key="{{ $province->province_id }}" value="{{ $province->province_id }}">
                                            {{ $province->province_name }}</option>
                                    @endforeach
                                </select>
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
                                            class="radio @error("form.location_of_residence") radio-error @enderror"
                                            value="city">
                                        <span class="ml-2">City</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" wire:model="form.location_of_residence"
                                            class="radio @error("form.location_of_residence") radio-error @enderror"
                                            value="municipality">
                                        <span class="ml-2">Municipality</span>
                                    </label>
                                </div>
                            </div>
                        @break

                        @default
                            @if ($question->question)
                                @php
                                    $label = ucfirst($question->question->label);
                                    $fieldKey = str_replace("_", "", $question->question->label);
                                    $options = $question->question->questionOption;
                                @endphp

                                <div class="mt-2">
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
                                                            <input type="radio"
                                                                wire:model="form.custom_questions.{{ $fieldKey }}"
                                                                class="radio {{ $errors->has("form.custom_questions." . $fieldKey) ? "radio-error" : "" }}"
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
                                                                wire:model="form.custom_questions.{{ $fieldKey }}">
                                                            <span class="ml-2">{{ $option->option_text }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                                @error("form.custom_questions.$fieldKey")
                                                    <p class="text-error mt-1">Select at least one.</p>
                                                @enderror
                                            @break

                                            @default
                                                <select
                                                    class="select {{ $errors->has("form.custom_questions.$fieldKey") ? "select-error" : "" }} w-full"
                                                    wire:model="form.custom_questions.{{ $fieldKey }}">
                                                    <option>Select {{ $label }}</option>
                                                    @foreach ($options as $key => $option)
                                                        <option value="{{ $option->option_value }}" wire:key="{{ $key }}">
                                                            {{ ucfirst($option->option_text) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error("form.custom_questions.$fieldKey")
                                                    <p class="text-error mt-1">Select at least one.</p>
                                                @enderror
                                        @endswitch
                                    @else
                                        <div>
                                            <input type="{{ $question->question->type }}" @class([
                                                "input w-full ",
                                                "input-error" => $errors->has("form.custom_questions.$fieldKey"),
                                            ])
                                                wire:model="form.custom_questions.{{ $fieldKey }}">
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endswitch
                    @endforeach
                </div>
            </div>
        </div>
    </div>

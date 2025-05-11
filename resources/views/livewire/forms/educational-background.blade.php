<div class="rounded-none px-3">
    <div class="card lg:w-250 md:w-230 mx-auto my-5 max-w-full">
        <div class="card-body gap-0 rounded-lg bg-white shadow-md">
            @foreach ($this->questionVisibility as $question)
                @switch($question->question_key)
                    @case("EB-educational_attainment")
                        <div wire:key='{{ $question->question_key }}'>
                            <div>
                                @foreach ($this->educational_attainment as $key => $row)
                                    <div @class([
                                        "card bg-base-100 border-1 border-base-300",
                                        "mt-5" => !$loop->first,
                                    ]) wire:key='{{ $key }}'>
                                        <div class="card-body">
                                            @if (count($this->educational_attainment) > 1)
                                                <div class="flex justify-end">
                                                    <button wire:target="removeRow({{ $key }})"
                                                        wire:click="removeRow({{ $key }})" wire:loading.attr="disabled"
                                                        type="button" class="btn btn-error btn-sm">
                                                        <span wire:loading wire:target="removeRow({{ $key }})"
                                                            class="loading loading-spinner"></span>
                                                        <i class="fa-solid fa-trash"
                                                            wire:target="removeRow({{ $key }})"></i>
                                                        Remove
                                                    </button>
                                                </div>
                                            @endif

                                            <div class="grid grid-cols-1 items-end gap-y-2 md:grid-cols-3">
                                                <div class="col-span-1">
                                                    <label
                                                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                                        Degree & Specialization
                                                    </label>
                                                    @php
                                                        $searchKey = "educational_attainment.$key.search_degree";
                                                    @endphp

                                                    <div x-data="{ open: false }"
                                                        @click.outside="if (open) {
                                                            if($wire.$get('{{ $searchKey }}') !== '') {
                                                               $wire.$set('{{ $searchKey }}', '');
                                                            }
                                                            open = false;
                                                        }"
                                                        class="relative w-full">
                                                        <input x-on:focus="open = true;"
                                                            wire:model.live.debounce.250ms="{{ $searchKey }}" type="text"
                                                            class="input @error("educational_attainment." . $key . ".degree_id") input-error @enderror w-full bg-white md:rounded-none">

                                                        <ul x-show="open"
                                                            class="z-999 border-base-300 absolute mt-1 max-h-60 w-full overflow-y-auto rounded-md border bg-white shadow-md">
                                                            @forelse($educational_attainment[$key]['degree_result'] as $degree)
                                                                <li x-on:click='open = false'
                                                                    wire:click="selectDegree({{ $key }}, {{ $degree->degree_id }}, '{{ $degree->degree_name }}')"
                                                                    class="hover:bg-primary hover:text-base-100 cursor-pointer p-3">
                                                                    {{ $degree->degree_name }}
                                                                </li>
                                                            @empty
                                                                <li class="text-error p-3">No results found.</li>
                                                            @endforelse
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="col-span-1">
                                                    <label
                                                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                                        College or University
                                                    </label>

                                                    @php
                                                        $searchKey = "educational_attainment.$key.search_hei";
                                                    @endphp

                                                    <div x-data="{ open: false }"
                                                        @click.outside="if (open) {
                                                        if($wire.$get('{{ $searchKey }}') !== '') {
                                                           $wire.$set('{{ $searchKey }}', '');
                                                        }
                                                        open = false;
                                                    }"
                                                        class="relative w-full">
                                                        <input x-on:focus="open = true;"
                                                            wire:model.live.debounce.250ms="{{ $searchKey }}" type="text"
                                                            class="input @error("educational_attainment." . $key . ".hei_id") input-error @enderror w-full bg-white md:rounded-none">

                                                        <ul x-show="open"
                                                            class="z-999 border-base-300 absolute mt-1 max-h-60 w-full overflow-y-auto rounded-md border bg-white shadow-md">
                                                            @forelse($educational_attainment[$key]['hei_result'] as $hei)
                                                                <li x-on:click='open = false'
                                                                    wire:click="selectHEI({{ $key }}, {{ $hei->hei_id }}, '{{ $hei->hei_name }}')"
                                                                    class="hover:bg-primary hover:text-base-100 cursor-pointer p-3">
                                                                    {{ $hei->hei_name }}
                                                                </li>
                                                            @empty
                                                                <li class="text-error p-3">No results found.</li>
                                                            @endforelse
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="col-span-1">
                                                    <label
                                                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                                        Year Graduated
                                                    </label>
                                                    <input
                                                        wire:model="educational_attainment.{{ $key }}.year_graduated"
                                                        type="number" min="1900" max="2100" step="1"
                                                        class="input @error("educational_attainment." . $key . ".year_graduated") select-error @enderror w-full bg-white md:rounded-none">
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <label class="text-neutral mb-2 block text-sm font-semibold">Honor</label>
                                                @foreach ($row["honor"] as $honor_key => $honor)
                                                    <div class="mb-2 flex items-center" wire:key='{{ $honor_key }}'>
                                                        <input type="text"
                                                            class="input @error("educational_attainment." . $key . ".honor." . $honor_key) input-error @enderror flex-1 rounded-none bg-white"
                                                            wire:model="educational_attainment.{{ $key }}.honor.{{ $honor_key }}">
                                                        @if ($loop->first)
                                                            <button type="button" wire:click='addHonor({{ $key }})'
                                                                class="btn btn-secondary rounded-none"
                                                                wire:target="addHonor({{ $key }})"
                                                                wire:loading.attr="disabled">
                                                                <span wire:loading wire:target="addHonor({{ $key }})"
                                                                    class="loading loading-spinner"></span>
                                                                <i class="fa-solid fa-plus" wire:loading.remove
                                                                    wire:target="addHonor({{ $key }})"></i>
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-error rounded-none"
                                                                wire:target="removeHonor({{ $key }}, {{ $honor_key }})"
                                                                wire:click="removeHonor({{ $key }}, {{ $honor_key }})"
                                                                wire:loading.attr="disabled">
                                                                <span wire:loading
                                                                    wire:target="removeHonor({{ $key }}, {{ $honor_key }})"
                                                                    class="loading loading-spinner"></span>
                                                                <i class="fa-solid fa-trash"
                                                                    wire:target="removeHonor({{ $key }}, {{ $honor_key }})"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="mt-5 flex justify-end">
                                    <button class="btn btn-primary btn-sm" wire:loading.attr="disabled"
                                        wire:click='addEducationAttainmentRow'>
                                        <span wire:loading wire:target="addEducationAttainmentRow"
                                            class="loading loading-spinner"></span>
                                        <i class="fa-solid fa-plus" wire:loading.remove
                                            wire:target="addEducationAttainmentRow"></i>
                                        Add New Degree
                                    </button>
                                </div>
                            </div>

                            <div class="divider"></div>
                        </div>
                    @break

                    @case("EB-professional_examination")
                        <div wire:key='{{ $question->question_key }}'>
                            @foreach ($professional_examination as $key => $row)
                                <div class="{{ !$loop->first ? "mt-2" : "" }} grid w-full grid-cols-1 items-end gap-y-2 md:grid-cols-4"
                                    wire:key="{{ $key }}">

                                    <div class="col-span-1">
                                        @if ($loop->first)
                                            <label class="text-neutral mb-2 block text-sm font-semibold">
                                                Name of Examination
                                            </label>
                                        @endif
                                        <input type="text"
                                            wire:model="professional_examination.{{ $key }}.name_of_examination"
                                            @class([
                                                "input w-full md:rounded-none",
                                                "input-error" => $errors->has(
                                                    "professional_examination." . $key . ".name_of_examination"),
                                                "mt-2" => !$loop->first,
                                            ])>

                                    </div>

                                    <div class="col-span-1">
                                        @if ($loop->first)
                                            <label class="text-neutral mb-2 block text-sm font-semibold">
                                                Date Taken
                                            </label>
                                        @endif
                                        <input type="date"
                                            wire:model="professional_examination.{{ $key }}.date_taken"
                                            class="input {{ !$loop->first ? "mt-2" : "" }} @error("professional_examination." . $key . ".date_taken") input-error @enderror w-full md:rounded-none md:border-x-0">
                                    </div>

                                    <div class="col-span-1">
                                        @if ($loop->first)
                                            <label class="text-neutral mb-2 block text-sm font-semibold">
                                                Rating
                                            </label>
                                        @endif
                                        <input type="text"
                                            wire:model="professional_examination.{{ $key }}.rating"
                                            class="input {{ !$loop->first ? "mt-2" : "" }} @error("professional_examination." . $key . ".rating") input-error @enderror w-full md:rounded-none">
                                    </div>

                                    <div>
                                        @if ($loop->first)
                                            <button class="btn btn-secondary mt-2 w-full md:rounded-none" type="button"
                                                wire:click="addProfessionalExaminationRow" wire:loading.attr="disabled">
                                                <span wire:loading wire:target="addProfessionalExaminationRow"
                                                    class="loading loading-spinner"></span>
                                                <i wire:target="addProfessionalExaminationRow" wire:loading.remove
                                                    class="fa-solid fa-plus"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-error mt-2 w-full md:rounded-none" type="button"
                                                wire:click="deleteProfessionalExaminationRow({{ $key }})"
                                                wire:loading.attr="disabled"
                                                wire:target='deleteProfessionalExaminationRow({{ $key }})'>
                                                <span wire:loading
                                                    wire:target="deleteProfessionalExaminationRow({{ $key }})"
                                                    class="loading loading-spinner"></span>
                                                <i wire:target="deleteProfessionalExaminationRow({{ $key }})"
                                                    wire:loading.remove class="fa-solid fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <div class="divider"></div>
                        </div>
                    @break

                    @case("EB-reason_for_course")
                        <div class="mt-2" wire:key='{{ $question->question_key }}'>
                            <p class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                Reason(s)
                                for taking the course(s) or
                                pursuing degree(s) </p>
                            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                                <div>
                                    <h6 class="text-neutral text-sm font-semibold">Undergraduate/AB/BS</h6>

                                    @foreach ($reason_options as $key => $option)
                                        <label class="mt-2 flex items-center space-y-2" :key="{{ "option-" . $key }}">
                                            <input type="checkbox" class="checkbox" value="{{ $option }}"
                                                wire:model='reasons_for_undergraduate.checkboxes'>
                                            <span class="ml-2">{{ $option }}</span>
                                        </label>
                                    @endforeach

                                    <input type="text" placeholder="Others, please specify"
                                        wire:model="reasons_for_undergraduate.input" class="input mt-2 w-full">
                                </div>

                                <div>
                                    <h6 class="text-neutral text-sm font-semibold">Graduate/MS/MA/Ph.D</h6>

                                    @foreach ($reason_options as $key => $option)
                                        <label class="mt-2 flex items-center space-y-2" :key="{{ "option-" . $key }}">
                                            <input type="checkbox" class="checkbox" value="{{ $option }}"
                                                wire:model='reasons_for_graduate.checkboxes'>
                                            <span class="ml-2">{{ $option }}</span>
                                        </label>
                                    @endforeach

                                    <input type="text" placeholder="Others, please specify"
                                        wire:model="reasons_for_graduate.input" class="input mt-2 w-full">
                                </div>

                            </div>

                            @error("reasons_for_undergraduate.checkboxes")
                                <div class="mt-1">
                                    <p class="text-error">
                                        {{ $message }}
                                    </p>
                                </div>
                            @enderror

                            @error("reasons_for_undergraduate.input")
                                <div class="mt-1">
                                    <p class="text-error">
                                        {{ $message }}
                                    </p>
                                </div>
                            @enderror

                            @error("reasons_for_graduate.checkboxes")
                                <div class="mt-1">
                                    <p class="text-error">
                                        {{ $message }}
                                    </p>
                                </div>
                            @enderror

                            @error("reasons_for_graduate.input")
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
                            <div wire:key='{{ $question->question_key }}'>
                                @php
                                    $label = ucfirst($question->question->label);
                                    $field_key = str_replace("_", " ", $question->question->label);
                                    $options = $question->question->questionOption;
                                @endphp
                                <div class="divider"></div>

                                <div>
                                    <label
                                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                        {{ $label }}
                                    </label>

                                    @if ($question->question->has_child)
                                        @switch($question->question->type)
                                            @case("radio")
                                                <div class="flex items-center gap-4">
                                                    @foreach ($options as $item)
                                                        <label
                                                            class="{{ $errors->has("custom_questions." . $field_key) ? "radio-error" : "" }} flex items-center"
                                                            wire:key="{{ $item->question_option_id }}">
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
                                                            <input type="checkbox" class="checkbox"
                                                                value="{{ $option->option_value }}"
                                                                wire:model="custom_questions.{{ $field_key }}">
                                                            <span class="ml-2">{{ $option->option_text }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                                @error("custom_questions" . $field_key)
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
                                        @endswitch
                                    @else
                                        <input type="{{ $question->question->type }}"
                                            class="input {{ $errors->has("custom_questions." . $field_key) ? "input-error" : "" }} w-full"
                                            wire:model="custom_questions.{{ $field_key }}">
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endswitch
                @endforeach
            </div>
        </div>
    </div>

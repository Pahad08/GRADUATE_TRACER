<div class="rounded-none px-3">
    <div class="card lg:w-250 md:w-230 mx-auto my-5 max-w-full">
        <div class="card-body border-base-300 bg-base-200 gap-0 rounded-lg border shadow-md">
            @foreach ($this->questionVisibility as $question)
                @switch($question->question_key)
                    @case("EB-educational_attainment")
                        <div wire:key='{{ $question->question_key }}'>
                            <div>
                                @foreach ($this->educational_attainment as $key => $row)
                                    <div @class([
                                        "card bg-base-100 border border-base-300",
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
                                                        class="text-neutral after:text-error mb-2 block text-sm font-semibold after:content-['*']">
                                                        College or University
                                                    </label>

                                                    <div x-data="{
                                                        open: false,
                                                        search: '',
                                                        currentHEI: '',
                                                        key: '{{ $key }}',
                                                        results: {},
                                                        heis: {},
                                                        get filtered() {
                                                            return Object.entries(this.results).filter(([_, hei]) =>
                                                                this.search === '' || hei.instName.toLowerCase().includes(this.search.toLowerCase())
                                                            );
                                                        },
                                                        reset() {
                                                            if (this.search == '') {
                                                                $wire.dispatch('resetHEI', { key: this.key });
                                                                $dispatch('reset-degree');
                                                                this.currentHEI = '';
                                                            } else if (this.currentHEI !== '') {
                                                                this.search = this.currentHEI;
                                                            }
                                                    
                                                            this.open = false;
                                                        }
                                                    }" x-init="(async () => {
                                                        try {
                                                            const response = await fetch('/fetch-unique-hei', {
                                                                method: 'GET',
                                                                headers: {
                                                                    'Content-Type': 'application/json',
                                                                    'PORTAL-API': 'T9bWNl3UFEO9pVOQOyM2nc7k3A9CvxUu',
                                                                }
                                                            });
                                                            const data = await response.json();
                                                            const mappedHei = Array.from(
                                                                data
                                                                .reduce((map, item) => {
                                                                    if (!map.has(item.instName)) {
                                                                        map.set(item.instName, {
                                                                            instCode: item.instCode,
                                                                            instName: item.instName,
                                                                            heiID: item.heiID,
                                                                            programID: item.programID,
                                                                            programName: item.programName,
                                                                            majorName: item.majorName
                                                                        });
                                                                    }
                                                                    return map;
                                                                }, new Map())
                                                            ).reduce((obj, [_, value]) => {
                                                                obj[value.instCode] = value;
                                                                return obj;
                                                            }, {});
                                                            results = mappedHei;
                                                            heis = data;
                                                        } catch (error) {
                                                            console.error('Fetch failed', error);
                                                            results = { error: 'Error fetching data' };
                                                        }
                                                    })()"
                                                        @click.outside="if (open) reset()" class="relative w-full"
                                                        x-on:graduate-created.window="search = ''; currentHEI = '';">
                                                        <input x-on:focus="open = true" x-model="search" type="text"
                                                            class="input @error("educational_attainment." . $key . ".hei") input-error @enderror w-full bg-white md:rounded-none" />
                                                        <ul x-show="open" x-transition
                                                            class="border-base-300 absolute z-50 mt-1 max-h-60 w-full overflow-y-auto rounded-md border bg-white shadow-md">
                                                            <template x-if="filtered.length > 0">
                                                                <template x-for="[hei_key, hei] in filtered"
                                                                    :key="hei_key">
                                                                    <li x-on:click="$dispatch('hei-selected',{key:key, hei_key:hei_key, instName: hei.instName, heis: heis});
                                                                    open = false;$wire.call('selectHEI', key, hei_key, hei.instName); search = hei.instName; currentHEI = hei.instName"
                                                                        class="hover:bg-primary hover:text-base-100 cursor-pointer p-3"
                                                                        x-text="hei.instName"></li>
                                                                </template>
                                                            </template>
                                                            <template x-if="filtered.length === 0">
                                                                <li class="p-3"><span
                                                                        class="loading loading-dots loading-sm"></span>
                                                                </li>
                                                            </template>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="col-span-1">
                                                    <label
                                                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                                        Degree & Specialization
                                                    </label>
                                                    <div x-data="{
                                                        open: false,
                                                        search: '',
                                                        key: '{{ $key }}',
                                                        degrees: [],
                                                        get filtered() {
                                                            return this.search === '' ?
                                                                this.degrees :
                                                                this.degrees.filter(degree =>
                                                                    degree.programName.toLowerCase().includes(this.search.toLowerCase())
                                                                );
                                                        },
                                                        reset() {
                                                            if (this.search !== '' && this.degrees.length > 0) {
                                                                $wire.call('selectDegree', this.key, this.search);
                                                            } else if (this.search === '' && this.degrees.length > 0) {
                                                                $wire.call('selectDegree', this.key, '');
                                                            }
                                                    
                                                            this.open = false;
                                                        }
                                                    }" @click.outside="if (open) reset()"
                                                        class="relative w-full"
                                                        x-on:hei-selected.window="degrees = Object.values(
                                                            Object.values($event.detail.heis)
                                                                .filter(item => item.instCode === $event.detail.hei_key)
                                                                .reduce((grouped, item) => {
                                                                    const key = item.programName;
                                                                    if (!grouped[key]) grouped[key] = [];
                                                                    grouped[key].push(item);
                                                                    return grouped;
                                                                }, {})
                                                        ).flatMap(group => {
                                                            const programName = group[0].programName;
                                                            const hasMajor = group.filter(item => item.majorName && item.majorName.trim() !== '');

                                                            if (hasMajor.length > 0) {
                                                                return hasMajor.map(item => ({
                                                                    programName: `${programName} Major in ${item.majorName}`,
                                                                    programID: item.programID
                                                                }));
                                                            } else {
                                                                const first = group[0];
                                                                return [{
                                                                    programName: programName,
                                                                    programID: first.programID
                                                                }];
                                                            }
                                                        });"
                                                        {{-- wire:model="educational_attainment.{{ $key }}.degree" --}}
                                                        x-on:degree-result.window="degrees = $event.detail[0]"
                                                        x-on:graduate-created.window="search = ''; degrees=[];"
                                                        x-on:reset-degree.window='search = ""; degrees = [];'>
                                                        <input x-on:focus="open = true" x-model="search" type="text"
                                                            wire:loading.attr="disabled" wire:target='selectHEI'
                                                            class="input @error("educational_attainment." . $key . ".degree") input-error @enderror w-full bg-white md:rounded-none" />

                                                        <ul x-show="open" x-transition
                                                            class="z-999 border-base-300 absolute mt-1 max-h-60 w-full overflow-y-auto rounded-md border bg-white shadow-md">
                                                            <template x-if="filtered.length > 0">
                                                                <template x-for="(degree, degree_key) in filtered"
                                                                    :key="degree_key">
                                                                    <li x-on:click="open = false;$wire.call('selectDegree', key, degree.programName); 
                                                                    search = degree.programName;"
                                                                        class="hover:bg-primary hover:text-base-100 cursor-pointer p-3"
                                                                        x-text="degree.programName"></li>
                                                                </template>
                                                            </template>

                                                            <template x-if="degrees.length === 0">
                                                                <li class="text-error p-3">Please select a university first.
                                                                </li>
                                                            </template>
                                                        </ul>
                                                    </div>

                                                </div>

                                                <div class="col-span-1">
                                                    <label
                                                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                                        Year Graduated
                                                    </label>
                                                    <select
                                                        wire:model="educational_attainment.{{ $key }}.academic_year_id"
                                                        class="select @error("educational_attainment." . $key . ".academic_year_id") select-error @enderror w-full md:rounded-none">
                                                        <option value="" disabled selected>Select Academic year</option>
                                                        @foreach (\App\Models\AcademicYear::orderBy("start_year", "desc")->get() as $year)
                                                            <option value="{{ $year->academic_year_id }}">
                                                                {{ $year->start_year . "-" . $year->end_year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <p class="text-base-content my-1 italic">Note: If the degree is not in the
                                                selection enter full name of the degree.</p>

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
                                                Eligibilities/licenses/certification
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
                                            <input type="checkbox" class="checkbox border-base-300 bg-white"
                                                value="{{ $option }}"
                                                wire:model='reasons_for_undergraduate.checkboxes'>
                                            <span class="ml-2">{{ $option }}</span>
                                        </label>
                                    @endforeach

                                    <input type="text" placeholder="Others, please specify"
                                        wire:model="reasons_for_undergraduate.input" class="input mt-2 w-full">

                                    @if ($errors->has("reasons_for_undergraduate.checkboxes") || $errors->has("reasons_for_undergraduate.input"))
                                        <div class="mt-1">
                                            <p class="text-error">
                                                {{ $errors->first("reasons_for_undergraduate.checkboxes") ?? $errors->first("reasons_for_undergraduate.input") }}
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <h6 class="text-neutral text-sm font-semibold">Graduate/MS/MA/Ph.D</h6>

                                    @foreach ($reason_options as $key => $option)
                                        <label class="mt-2 flex items-center space-y-2" :key="{{ "option-" . $key }}">
                                            <input type="checkbox" class="checkbox border-base-300 bg-white"
                                                value="{{ $option }}" wire:model='reasons_for_graduate.checkboxes'>
                                            <span class="ml-2">{{ $option }}</span>
                                        </label>
                                    @endforeach

                                    <input type="text" placeholder="Others, please specify"
                                        wire:model="reasons_for_graduate.input" class="input mt-2 w-full">

                                    @if ($errors->has("reasons_for_graduate.checkboxes") || $errors->has("reasons_for_graduate.input"))
                                        <div class="mt-1">
                                            <p class="text-error">
                                                {{ $errors->first("reasons_for_graduate.checkboxes") ?? $errors->first("reasons_for_graduate.input") }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
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
                                        @if ($question->question->type === "radio")
                                            <div>
                                                <div class="flex items-center gap-4">
                                                    @foreach ($options as $item)
                                                        <label
                                                            class="{{ $errors->has("custom_questions." . $field_key) ? "radio-error" : "" }} border-base-300 flex items-center bg-white"
                                                            wire:key="{{ $item->question_option_id }}">
                                                            <input type="radio"
                                                                wire:model="custom_questions.{{ $field_key }}"
                                                                class="radio {{ $errors->has("custom_questions." . $field_key) ? "radio-error" : "" }}"
                                                                value="{{ $item->option_value }}">
                                                            <span class="ml-2">{{ $item->option_text }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>

                                                @if ($errors->has("form.custom_questions.$field_key"))
                                                    <p class="text-error mt-1">
                                                        {{ $errors->first("form.custom_questions.$field_key") }}</p>
                                                @endif
                                            </div>
                                        @elseif($question->question->type === "checkbox")
                                            <div class="flex flex-wrap gap-4">
                                                @foreach ($options as $key => $option)
                                                    <label class="mt-2 flex items-center" wire:key="{{ $key }}">
                                                        <input type="checkbox" class="checkbox border-base-300 bg-white"
                                                            value="{{ $option->option_value }}"
                                                            wire:model="custom_questions.{{ $field_key }}">
                                                        <span class="ml-2">{{ $option->option_text }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            @if ($errors->has("form.custom_questions.$field_key"))
                                                <p class="text-error mt-1">
                                                    {{ $errors->first("form.custom_questions.$field_key") }}</p>
                                            @endif
                                        @else
                                            <div>
                                                <select
                                                    class="select border-base-300 {{ $errors->has("custom_questions." . $field_key) ? "select-error" : "" }} w-full bg-white"
                                                    wire:model="custom_questions.{{ $field_key }}">
                                                    <option>Select {{ $label }}</option>
                                                    @foreach ($options as $key => $option)
                                                        <option value="{{ $option->option_value }}"
                                                            wire:key="{{ $key }}">
                                                            {{ ucfirst($option->option_text) }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @if ($errors->has("custom_questions." . $field_key))
                                                    <p class="text-error mt-1">
                                                        {{ $errors->first("custom_questions." . $field_key) }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        <div>

                                        </div>
                                        <input type="{{ $question->question->type }}"
                                            class="input {{ $errors->has("custom_questions." . $field_key) ? "input-error" : "" }} w-full"
                                            wire:model="custom_questions.{{ $field_key }}">

                                        @if ($errors->first("custom_questions." . $field_key))
                                            <p class="text-error mt-1">
                                                {{ $errors->first("form.custom_questions.$field_key") }}</p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endif
                @endswitch
            @endforeach

            <div class="join mt-4 justify-end">
                <button class="join-item btn btn-secondary"
                    x-on:click="activeTab = 'tracer-components.general-information';window.scrollTo({ top: 0, behavior: 'smooth' })"><i
                        class="fa-solid fa-arrow-left"></i> Previous</button>
                <button class="join-item btn btn-primary"
                    x-on:click="activeTab = 'tracer-components.studies-information';window.scrollTo({ top: 0, behavior: 'smooth' })">Next
                    <i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>

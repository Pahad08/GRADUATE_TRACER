<div class="rounded-none px-3">
    <div class="card lg:w-250 md:w-230 border-1 border-base-300 mx-auto my-5 max-w-full bg-white">
        <div class="card-body gap-0 rounded-lg shadow-md">
            @foreach ($this->educational_attainment as $key => $row)
                <div x-data="{ educational_attainment_error: {} }"
                    x-on:educational-attainment-error.window="educational_attainment_error=$event.detail[0];"
                    class="{{ $loop->first ? "mt-2" : "" }} grid grid-cols-1 items-end gap-y-2 md:grid-cols-5"
                    wire:key="{{ "educational-attainment-" . $key }}">
                    <div class="col-span-1">
                        @if ($loop->first)
                            <label
                                class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                Degree & Specialization
                            </label>
                        @endif
                        <select class="select {{ !$loop->first ? "mt-2" : "" }} w-full bg-white md:rounded-none"
                            :class="(errors['tracer-components.educational-background'] && errors[
                                'tracer-components.educational-background'][
                                'educational_attainment.{{ $key }}.degree_id'
                            ]) ||
                            educational_attainment_error['educational_attainment.{{ $key }}.degree_id'] ?
                                'select-error' : ''"
                            wire:model="educational_attainment.{{ $key }}.degree_id">
                            <option value="">Degree & Specialization</option>
                            @foreach ($degree_levels as $degree_level)
                                <option value="{{ $degree_level->degree_id }}"
                                    wire:key={{ "degree-" . $degree_level->degree_id }}>
                                    {{ $degree_level->degree_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1">
                        @if ($loop->first)
                            <label
                                class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                College or University
                            </label>
                        @endif
                        <select class="select {{ !$loop->first ? "mt-2" : "" }} w-full bg-white md:rounded-none"
                            :class="(errors['tracer-components.educational-background'] && errors[
                                'tracer-components.educational-background'][
                                'educational_attainment.{{ $key }}.university_id'
                            ]) ||
                            educational_attainment_error[
                                    'educational_attainment.{{ $key }}.university_id'] ? 'select-error' :
                                'md:border-x-0'"
                            wire:model="educational_attainment.{{ $key }}.university_id">
                            <option value="" selected>University</option>
                            @foreach ($universities as $university)
                                <option value="{{ $university->university_id }}"
                                    wire:key={{ "university-" . $university->university_id }}>
                                    {{ $university->university_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1">
                        @if ($loop->first)
                            <label
                                class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                Year Graduated
                            </label>
                        @endif
                        <input type="number" min="1900" max="2100" step="1"
                            class="input {{ !$loop->first ? "mt-2" : "" }} w-full bg-white md:rounded-none"
                            :class="(errors['tracer-components.educational-background'] && errors[
                                'tracer-components.educational-background'][
                                'educational_attainment.{{ $key }}.year_graduated'
                            ]) ||
                            educational_attainment_error[
                                    'educational_attainment.{{ $key }}.year_graduated'] ? 'input-error' :
                                'md:border-r-0'"
                            wire:model="educational_attainment.{{ $key }}.year_graduated">
                    </div>

                    <div class="col-span-1">
                        @if ($loop->first)
                            <label
                                class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                Honor or Award Received
                            </label>
                        @endif
                        <input type="text"
                            class="input {{ !$loop->first ? "mt-2" : "" }} w-full bg-white md:rounded-none"
                            :class="(errors['tracer-components.educational-background'] && errors[
                                'tracer-components.educational-background'][
                                'educational_attainment.{{ $key }}.honor'
                            ]) || educational_attainment_error[
                                'educational_attainment.{{ $key }}.honor'] ? 'input-error' : ''"
                            wire:model="educational_attainment.{{ $key }}.honor">
                    </div>

                    <div class="col-span-1">
                        @if ($loop->first)
                            <button class="btn btn-primary mt-2 w-full md:rounded-none" type="button"
                                wire:click="addEducationAttainmentRow" wire:loading.attr="disabled">
                                <span wire:loading wire:target="addEducationAttainmentRow"
                                    class="loading loading-spinner"></span>
                                <i class="fa-solid fa-plus text-white" wire:target="addEducationAttainmentRow"
                                    wire:loading.remove></i>
                            </button>
                        @else
                            <button wire:loading.attr="disabled" class="btn btn-primary mt-2 w-full md:rounded-none"
                                type="button" wire:click="deleteEducationAttainmentRow({{ $key }})">
                                <span wire:loading wire:target="deleteEducationAttainmentRow({{ $key }})"
                                    class="loading loading-spinner"></span>
                                <i class="fa-solid fa-trash text-white"
                                    wire:target="deleteEducationAttainmentRow({{ $key }})"
                                    wire:loading.remove></i>
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="divider"></div>

            @foreach ($professional_examination as $key => $row)
                <div x-data="{ professional_examination_error: {} }"
                    x-on:professional-examination-error.window="professional_examination_error=$event.detail[0];"
                    class="{{ !$loop->first ? "mt-2" : "" }} grid w-full grid-cols-1 items-end gap-y-2 md:grid-cols-4"
                    wire:key="{{ $key }}">

                    <div class="col-span-1">
                        @if ($loop->first)
                            <label
                                class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                Name of Examination
                            </label>
                        @endif
                        <input type="text"
                            wire:model="professional_examination.{{ $key }}.name_of_examination"
                            :class="(errors['tracer-components.educational-background'] && errors[
                                'tracer-components.educational-background'][
                                'professional_examination.{{ $key }}.name_of_examination'
                            ]) ||
                            professional_examination_error[
                                    'professional_examination.{{ $key }}.name_of_examination'] ?
                                'input-error' : ''"
                            class="input {{ !$loop->first ? "mt-2" : "" }} w-full bg-white md:rounded-none">
                    </div>

                    <div class="col-span-1">
                        @if ($loop->first)
                            <label
                                class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                Date Taken
                            </label>
                        @endif
                        <input type="date" wire:model="professional_examination.{{ $key }}.date_taken"
                            :class="(errors['tracer-components.educational-background'] && errors[
                                'tracer-components.educational-background'][
                                'professional_examination.{{ $key }}.date_taken'
                            ]) ||
                            professional_examination_error[
                                    'professional_examination.{{ $key }}.date_taken'] ? 'input-error' :
                                'md:border-x-0'"
                            class="input {{ !$loop->first ? "mt-2" : "" }} {{ $errors->has("professional_examination.$key.date_taken") ? "input-error" : "md:border-x-0" }} w-full bg-white md:rounded-none md:border-x-0">
                    </div>

                    <div class="col-span-1">
                        @if ($loop->first)
                            <label
                                class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                Rating
                            </label>
                        @endif
                        <input type="text" wire:model="professional_examination.{{ $key }}.rating"
                            :class="(errors['tracer-components.educational-background'] && errors[
                                'tracer-components.educational-background'][
                                'professional_examination.{{ $key }}.rating'
                            ]) ||
                            professional_examination_error[
                                'professional_examination.{{ $key }}.rating'] ? 'input-error' : ''"
                            class="input {{ !$loop->first ? "mt-2" : "" }} {{ $errors->has("professional_examination.$key.rating") ? "input-error" : "" }} w-full bg-white md:rounded-none">
                    </div>

                    <div>
                        @if ($loop->first)
                            <button class="btn btn-primary mt-2 w-full md:rounded-none" type="button"
                                wire:click="addProfessionalExaminationRow" wire:loading.attr="disabled">
                                <span wire:loading wire:target="addProfessionalExaminationRow"
                                    class="loading loading-spinner"></span>
                                <i wire:target="addProfessionalExaminationRow" wire:loading.remove
                                    class="fa-solid fa-plus text-white"></i>
                            </button>
                        @else
                            <button class="btn btn-primary mt-2 w-full md:rounded-none" type="button"
                                wire:click="deleteProfessionalExaminationRow({{ $key }})"
                                wire:loading.attr="disabled">
                                <span wire:loading wire:target="deleteProfessionalExaminationRow({{ $key }})"
                                    class="loading loading-spinner"></span>
                                <i wire:target="deleteProfessionalExaminationRow({{ $key }})"
                                    wire:loading.remove class="fa-solid fa-trash text-white"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="divider"></div>

            <div>
                <label
                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Degree
                    level
                </label>

                <div class="flex items-center gap-4">
                    <label class="flex items-center">
                        <input type="radio" wire:model="type"
                            :class="errors['tracer-components.educational-background'] && errors[
                                    'tracer-components.educational-background']['type'] ?
                                'radio-error' : ''"
                            class="radio" value="undergraduate">
                        <span class="ml-2">Undergraduate</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" wire:model="type" class="radio"
                            :class="errors['tracer-components.educational-background'] && errors[
                                    'tracer-components.educational-background']['type'] ?
                                'radio-error' : ''"
                            value="graduate">
                        <span class="ml-2">Graduate</span>
                    </label>
                </div>
            </div>

            <div class="mt-2">
                <label
                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Reason(s)
                    for taking the course(s) or
                    pursuing degree(s) </label>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @foreach ($reason_options as $key => $option)
                        <label class="flex items-center" :key="{{ "option-" . $key }}">
                            <input type="checkbox" class="checkbox" value="{{ $option }}"
                                wire:model='reasons.checkboxes'>
                            <span class="ml-2">{{ $option }}</span>
                        </label>
                    @endforeach

                    <input type="text" placeholder="Others, please specify" wire:model="reasons.input"
                        class="input col-span-1 w-full bg-white md:col-span-2">
                </div>

                <template
                    x-if="errors['tracer-components.educational-background'] && errors['tracer-components.educational-background']['reasons.input']">
                    <div class="mt-1">
                        <p class="text-error"
                            x-text="errors['tracer-components.educational-background'] && errors['tracer-components.educational-background']['reasons.input']">
                        </p>
                    </div>
                </template>

                <template
                    x-if="errors['tracer-components.educational-background'] && errors['tracer-components.educational-background']['reasons.checkboxes']">
                    <div class="mt-1">
                        <p class="text-error"
                            x-text="errors['tracer-components.educational-background'] && errors['tracer-components.educational-background']['reasons.checkboxes']">
                        </p>
                    </div>
                </template>
            </div>
        </div>
    </div>

</div>

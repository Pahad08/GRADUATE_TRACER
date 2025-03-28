<div class="rounded-none px-3" x-data="{ isEmployed: '' }">
    <div class="card lg:w-250 md:w-230 border-1 border-base-300 mx-auto my-5 max-w-full bg-white">
        <div class="card-body rounded-lg shadow-md">
            <div class="grid grid-cols-1">
                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Are
                        you presently employed? </label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="radio"
                                :class="errors['tracer-components.employment-data'] && errors[
                                    'tracer-components.employment-data']['form.is_employed'] ? 'radio-error' : ''"
                                x-model="isEmployed" class="radio" value="yes" wire:model="form.is_employed">
                            <span class="ml-2">Yes</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio"
                                :class="errors['tracer-components.employment-data'] && errors[
                                    'tracer-components.employment-data']['form.is_employed'] ? 'radio-error' : ''"
                                x-model="isEmployed" class="radio" value="no" wire:model="form.is_employed">
                            <span class="ml-2">No</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio"
                                :class="errors['tracer-components.employment-data'] && errors[
                                    'tracer-components.employment-data']['form.is_employed'] ? 'radio-error' : ''"
                                class="radio" x-model="isEmployed" wire:model="form.is_employed" value="never">
                            <span class="ml-2">Never Employed</span>
                        </label>
                    </div>
                </div>

                <template x-if="isEmployed !== 'yes' && isEmployed !== ''">
                    <div>
                        <div class="divider"></div>

                        <label
                            class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                            Please state reason(s) why you are not yet employed. </label>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @foreach ($unemployment_reasons as $key => $reason)
                                <label class="flex items-center" wire:key="{{ "reason-" . $key }}">
                                    <input type="checkbox" class="checkbox" value="{{ $reason }}"
                                        wire:model="form.unemployment_reason.checkboxes">
                                    <span class="ml-2">{{ $reason }}</span>
                                </label>
                            @endforeach
                        </div>

                        <label class="mt-3 flex items-center">
                            <input type="text" class="input w-full bg-white"
                                placeholder="Other reason(s), please specify"
                                wire:model="form.unemployment_reason.input">
                        </label>

                        <template
                            x-if="(errors['tracer-components.employment-data'] && errors['tracer-components.employment-data']['form.unemployment_reason.input']) ||
                            (errors['tracer-components.employment-data'] && errors['tracer-components.employment-data']['form.unemployment_reason.checkboxes'])
                            ">
                            <div class="mt-1">
                                <p class="text-error">
                                    Provide atleast one reason.
                                </p>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="isEmployed === 'yes' && isEmployed !== ''">
                    <div x-data="{ isFirstJob: '', isRelated: '', is_curriculum_relevant_to_job: '' }">
                        <div class="divider"></div>

                        <div>
                            <label class="text-neutral mb-2 block text-sm font-semibold">Present Employment
                                Status</label>
                            <div class="flex flex-wrap gap-4">
                                @foreach ($employment_status as $key => $status)
                                    <label class="flex items-center" wire:key='{{ "status-" . $key }}'>
                                        <input type="radio"
                                            :class="errors['tracer-components.employment-data'] && errors[
                                                'tracer-components.employment-data'][
                                                'form.present_employment_status'
                                            ] ? 'radio-error' : ''"
                                            wire:model="form.present_employment_status" class="radio"
                                            value="{{ $status }}">
                                        <span class="ml-2">{{ $status }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div>
                            <label class="text-neutral mb-2 block text-sm font-semibold">Present occupation(Use the
                                following Phil. Standard Occupational Classification (PSOC), 1992 classification)
                            </label>
                            <select
                                :class="errors['tracer-components.employment-data'] && errors[
                                    'tracer-components.employment-data']['form.occupation'] ? 'select-error' : ''"
                                wire:model="form.occupation" class="select w-full bg-white">
                                <option selected disabled value="">Present occupation</option>
                                @foreach ($occupations as $key => $occupation)
                                    <option value="{{ $occupation }}" wire:key='{{ "occupation-" . $key }}'>
                                        {{ $occupation }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="divider"></div>

                        <div>
                            <label
                                class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Name
                                of Company or Organization including address </label>
                            <input
                                :class="errors['tracer-components.employment-data'] && errors[
                                    'tracer-components.employment-data']['form.company_name'] ? 'input-error' : ''"
                                type="text" wire:model="form.company_name" class="input w-full bg-white">
                        </div>

                        <div class="divider"></div>

                        <div>
                            <label class="text-neutral mb-2 block text-sm font-semibold">Major line of business of the
                                company you are presently employed in.</label>
                            <select
                                :class="errors['tracer-components.employment-data'] && errors[
                                    'tracer-components.employment-data']['form.industry'] ? 'select-error' : ''"
                                class="select w-full bg-white" wire:model="form.industry">
                                <option selected disabled value="">Major line of business</option>
                                @foreach ($industries as $key => $industry)
                                    <option value="{{ $industry }}" wire:key='{{ "industry-" . $key }}'>
                                        {{ $industry }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="divider"></div>

                        <div>
                            <label class="text-neutral mb-2 block text-sm font-semibold">Place of work</label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input type="radio"
                                        :class="errors['tracer-components.employment-data'] && errors[
                                                'tracer-components.employment-data']['form.place_of_work'] ?
                                            'radio-error' : ''"
                                        wire:model='form.place_of_work' class="radio" value="local">
                                    <span class="ml-2">Local</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio"
                                        :class="errors['tracer-components.employment-data'] && errors[
                                                'tracer-components.employment-data']['form.place_of_work'] ?
                                            'radio-error' : ''"
                                        wire:model='form.place_of_work' class="radio" value="abroad">
                                    <span class="ml-2">Abroad</span>
                                </label>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div>
                            <label class="text-neutral mb-2 block text-sm font-semibold">Is this your first job after
                                college?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input type="radio"
                                        :class="errors['tracer-components.employment-data'] && errors[
                                                'tracer-components.employment-data']['form.is_first_job'] ?
                                            'radio-error' : ''"
                                        wire:model="form.is_first_job" x-model="isFirstJob" class="radio"
                                        value="1">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio"
                                        :class="errors['tracer-components.employment-data'] && errors[
                                                'tracer-components.employment-data']['form.is_first_job'] ?
                                            'radio-error' : ''"
                                        wire:model="form.is_first_job" x-model="isFirstJob" class="radio"
                                        value="0">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <template x-if="isFirstJob === '1' && isFirstJob !== ''">
                            <div>
                                <div class="divider"></div>

                                <div>
                                    <label class="text-neutral mb-2 block text-sm font-semibold">What are your
                                        reason(s) for staying on the job?</label>
                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        @foreach ($reasons as $key => $reason)
                                            <label class="flex items-center" wire:key="{{ "reason-" . $key }}">
                                                <input type="checkbox" wire:model='form.job_retention.checkboxes'
                                                    value="{{ $reason }}" class="checkbox">
                                                <span class="ml-2">{{ $reason }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <div class="mt-3 flex items-center">
                                        <input type="text" wire:model='form.job_retention.input'
                                            class="input w-full bg-white"
                                            placeholder="Other reason(s), please specify">
                                    </div>

                                    <template
                                        x-if="(errors['tracer-components.employment-data'] && errors['tracer-components.employment-data']['form.job_retention.input']) ||
                                            (errors['tracer-components.employment-data'] && errors['tracer-components.employment-data']['form.job_retention.checkboxes'])">
                                        <div class="mt-1">
                                            <p class="text-error">
                                                Provide atleast one reason.
                                            </p>
                                        </div>
                                    </template>
                                </div>

                                <div class="divider"></div>

                                <div>
                                    <label class="text-neutral mb-2 block text-sm font-semibold">Is your first job
                                        related to the course you took up in college?</label>
                                    <div class="flex gap-4">
                                        <label class="flex items-center">
                                            <input type="radio"
                                                :class="errors['tracer-components.employment-data'] && errors[
                                                        'tracer-components.employment-data']['form.related_to_course'] ?
                                                    'radio-error' : ''"
                                                wire:model="form.related_to_course" x-model="isRelated"
                                                class="radio" value="1">
                                            <span class="ml-2">Yes</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio"
                                                :class="errors['tracer-components.employment-data'] && errors[
                                                        'tracer-components.employment-data']['form.related_to_course'] ?
                                                    'radio-error' : ''"
                                                wire:model="form.related_to_course" x-model="isRelated"
                                                class="radio" value="0">
                                            <span class="ml-2">No</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="divider" x-show="isRelated === '1' && isRelated !== ''" x-transition>
                                </div>

                                <template x-if="isRelated === '1' && isRelated !== ''">
                                    <div>
                                        <label class="text-neutral mb-2 block text-sm font-semibold">What were your
                                            reasons for accepting the job?</label>
                                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                            @foreach ($reasons as $key => $reason)
                                                <label class="flex items-center" wire:key="{{ "reason-" . $key }}">
                                                    <input type="checkbox" wire:model='form.job_acceptance.checkboxes'
                                                        value="{{ $reason }}" class="checkbox">
                                                    <span class="ml-2">{{ $reason }}</span>
                                                </label>
                                            @endforeach
                                        </div>

                                        <div class="mt-3 flex items-center">
                                            <input type="text" wire:model='form.job_acceptance.input'
                                                class="input w-full bg-white"
                                                placeholder="Other reason(s), please specify">
                                        </div>

                                        <template
                                            x-if="(errors['tracer-components.employment-data'] && errors['tracer-components.employment-data']['form.job_acceptance.input']) ||
                                                  (errors['tracer-components.employment-data'] && errors['tracer-components.employment-data']['form.job_acceptance.checkboxes'])">
                                            <div class="mt-1">
                                                <p class="text-error">
                                                    Provide atleast one reason.
                                                </p>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <template x-if="isFirstJob === '0' && isFirstJob !== ''">
                            <div class="divider"></div>
                        </template>

                        <template x-if="isFirstJob === '0' && isFirstJob !== ''">
                            <div>
                                <div>
                                    <label class="text-neutral mb-2 block text-sm font-semibold">What were your
                                        reason(s) for changing job?</label>
                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        @foreach ($reasons as $key => $reason)
                                            <label class="flex items-center" wire:key="{{ "reason-" . $key }}">
                                                <input type="checkbox" wire:model='form.job_change.checkboxes'
                                                    class="checkbox" value="{{ $reason }}">
                                                <span class="ml-2">{{ $reason }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <div class="mt-3 flex items-center">
                                        <input type="text" wire:model='form.job_change.input'
                                            class="input w-full bg-white"
                                            placeholder="Other reason(s), please specify">
                                    </div>

                                    <template
                                        x-if="(errors['tracer-components.employment-data'] && errors['tracer-components.employment-data']['form.job_change.input']) ||
                                                  (errors['tracer-components.employment-data'] && errors['tracer-components.employment-data']['form.job_change.checkboxes'])">
                                        <div class="mt-1">
                                            <p class="text-error">
                                                Provide atleast one reason.
                                            </p>
                                        </div>
                                    </template>
                                </div>

                                <div class="divider"></div>

                                <div>
                                    <label class="text-neutral mb-2 block text-sm font-semibold">How long did you stay
                                        in your first job?</label>
                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        @foreach ($job_change_reasons as $key => $reason)
                                            <label class="flex items-center"
                                                wire:key="{{ "job-change-reason-" . $key }}">
                                                <input type="radio" wire:model="form.first_job_duration"
                                                    class="radio" value="{{ $reason }}">
                                                <span class="ml-2">{{ $reason }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <div class="mt-3 flex items-center">
                                        <input type="text" wire:model='form.first_job_duration'
                                            class="input w-full bg-white" placeholder="Others, please specify">
                                    </div>

                                    <template
                                        x-if="(errors['tracer-components.employment-data'] && errors['tracer-components.employment-data']['form.first_job_duration'])">
                                        <div class="mt-1">
                                            <p class="text-error">
                                                Provide atleast one.
                                            </p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <div class="divider"></div>

                        <div>
                            <label class="text-neutral mb-2 block text-sm font-semibold">How did you find your first
                                job?</label>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                @foreach ($first_job_sources as $key => $source)
                                    <label class="flex items-center" wire:key='{{ "source-" . $key }}'>
                                        <input type="checkbox" value="{{ $source }}" class="checkbox"
                                            :class="errors['form.job_source.checkboxes'] ? 'checkbox-error' : ''"
                                            wire:model='form.job_source.checkboxes'>
                                        <span class="ml-2">{{ $source }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <div class="mt-3 flex items-center">
                                <input type="text" wire:model='form.job_source.input'
                                    :class="errors['form.job_source.input'] ? 'input-error' : ''"
                                    class="input w-full bg-white" placeholder="Other reason(s), please specify">
                            </div>
                            <template
                                x-if="(errors['tracer-components.employment-data'] && errors['tracer-components.employment-data']['form.job_source.input']) ||
                            (errors['tracer-components.employment-data'] && errors['tracer-components.employment-data']['form.job_source.checkboxes'])
                            ">
                                <div class="mt-1">
                                    <p class="text-error">
                                        Provide atleast one reason.
                                    </p>
                                </div>
                            </template>
                        </div>

                        <div class="divider"></div>

                        <div>
                            <label class="text-neutral mb-2 block text-sm font-semibold">How long did it take you to
                                land your first job?</label>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                @foreach ($first_job_search_durations as $key => $duration)
                                    <label class="flex items-center" wire:key='{{ "duration-" . $key }}'>
                                        <input type="radio" wire:model="form.first_job_search_duration"
                                            :class="errors['form.first_job_search_duration'] ? 'radio-error' : ''"
                                            class="radio" value="{{ $duration }}">
                                        <span class="ml-2">{{ $duration }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-3 flex flex-col">
                                <label class="text-neutral mb-2 font-semibold">Other reason(s), please specify</label>
                                <input type="text" wire:model='form.first_job_search_duration'
                                    :class="errors['form.first_job_search_duration'] ? 'input-error' : ''"
                                    class="input w-full bg-white">
                            </div>

                            <template
                                x-if="(errors['tracer-components.employment-data'] && errors['tracer-components.employment-data']['form.first_job_search_duration'])">
                                <div class="mt-1">
                                    <p class="text-error">
                                        Provide atleast one.
                                    </p>
                                </div>
                            </template>
                        </div>

                        <div class="divider"></div>

                        <div>
                            <label class="text-neutral mb-4 block text-sm font-semibold">Job Level Position</label>
                            <div class="grid grid-cols-1 gap-2">
                                <div>
                                    <label class="text-neutral mb-2 block text-sm font-semibold">First Job</label>
                                    <div class="flex flex-col gap-4 md:flex-row">
                                        @foreach ($job_levels as $key => $job_level)
                                            <label class="flex items-center" wire:key='{{ "job-level-" . $key }}'>
                                                <input type="radio" wire:model="form.first_job_level"
                                                    :class="errors['tracer-components.employment-data'] && errors[
                                                        'tracer-components.employment-data'][
                                                        'form.first_job_level'
                                                    ] ? 'radio-error' : ''"
                                                    class="radio" value="{{ $job_level }}">
                                                <span class="ml-2">{{ $job_level }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <label class="text-neutral mb-2 block text-sm font-semibold">Current or Present
                                        Job</label>
                                    <div class="flex flex-col gap-4 md:flex-row">
                                        @foreach ($job_levels as $key => $job_level)
                                            <label class="flex items-center" wire:key='{{ "job-level-" . $key }}'>
                                                <input type="radio" wire:model="form.current_job_level"
                                                    :class="errors['tracer-components.employment-data'] && errors[
                                                        'tracer-components.employment-data'][
                                                        'form.current_job_level'
                                                    ] ? 'radio-error' : ''"
                                                    class="radio" value="{{ $job_level }}">
                                                <span class="ml-2">{{ $job_level }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div>
                            <label class="text-neutral mb-2 block text-sm font-semibold">What is your
                                initial gross monthly earning in your first job after college?</label>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                @foreach ($salaryRanges as $key => $range)
                                    <label class="flex items-center" wire:key='{{ "range-" . $key }}'>
                                        <input type="radio" wire:model="form.first_job_initial_gross"
                                            :class="errors['tracer-components.employment-data'] && errors[
                                                'tracer-components.employment-data'][
                                                'form.first_job_initial_gross'
                                            ] ? 'radio-error' : ''"
                                            class="radio" value="{{ $range }}">
                                        <span class="ml-2">{{ $range }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div>
                            <label class="text-neutral mb-2 block text-sm font-semibold">
                                Was the curriculum you had in college relevant to your
                                first job?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input type="radio" class="radio" x-model="is_curriculum_relevant_to_job"
                                        :class="errors['tracer-components.employment-data'] && errors[
                                            'tracer-components.employment-data'][
                                            'form.is_curriculum_relevant_to_job'
                                        ] ? 'radio-error' : ''"
                                        value="1" wire:model="form.is_curriculum_relevant_to_job">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" class="radio" x-model="is_curriculum_relevant_to_job"
                                        :class="errors['tracer-components.employment-data'] && errors[
                                            'tracer-components.employment-data'][
                                            'form.is_curriculum_relevant_to_job'
                                        ] ? 'radio-error' : ''"
                                        value="0" wire:model="form.is_curriculum_relevant_to_job">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <template x-if="is_curriculum_relevant_to_job === '1' && is_curriculum_relevant_to_job !== ''">
                            <div>
                                <div class="divider"></div>

                                <label class="text-neutral mb-2 block text-sm font-semibold">What competencies learned
                                    in college did you find very useful in your
                                    first job?</label>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    @foreach ($skills as $key => $skill)
                                        <label class="flex items-center" wire:key="{{ "skill-" . $key }}">
                                            <input type="checkbox" wire:model='form.skills.checkboxes'
                                                value="{{ $skill }}" class="checkbox">
                                            <span class="ml-2">{{ $skill }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="mt-3 flex items-center">
                                    <input type="text" wire:model='form.skills.input'
                                        class="input w-full bg-white" placeholder="Other reason(s), please specify">
                                </div>

                                <template
                                    x-if="(errors['tracer-components.employment-data'] && errors['tracer-components.employment-data']['form.skills.input']) ||
                                                (errors['tracer-components.employment-data'] && errors['tracer-components.employment-data']['form.skills.checkboxes'])">
                                    <div class="mt-1">
                                        <p class="text-error">
                                            Provide atleast one reason.
                                        </p>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>

                <div class="divider"></div>

                <div x-data="{ suggestion_error: {} }" x-on:suggestion-error.window="suggestion_error=$event.detail[0];">
                    <label class="text-neutral block text-sm font-semibold after:text-red-500 after:content-['*']">
                        List down suggestions to further improve your course curriculum
                    </label>
                    @foreach ($form->suggestions as $key => $row)
                        <div class="{{ !$loop->first ? "mt-2" : "" }} grid grid-cols-3 items-end gap-y-2"
                            wire:key="{{ "suggestion-" . $key }}">
                            <div class="col-span-2">
                                <input type="text"
                                    :class="(errors['tracer-components.employment-data'] && errors[
                                        'tracer-components.employment-data'][
                                        'form.suggestions.{{ $key }}'
                                    ]) ||
                                    suggestion_error['form.suggestions.{{ $key }}'] ?
                                        'input-error' :
                                        'focus:border-gray-300'"
                                    wire:model="form.suggestions.{{ $key }}"
                                    class="input {{ !$loop->first ? "mt-2" : "" }} w-full rounded-none bg-white">
                            </div>

                            <div class="col-span-1">
                                @if ($loop->first)
                                    <button wire:click='addSuggestionInput' wire:loading.attr="disabled"
                                        class="btn btn-primary mt-2 rounded-none" type="button">
                                        <span wire:loading wire:target="addSuggestionInput"
                                            class="loading loading-spinner"></span>
                                        <i wire:target="addSuggestionInput" wire:loading.remove
                                            class="fa-solid fa-plus text-white"></i>
                                    </button>
                                @else
                                    <button wire:click='deleteSuggestionInput({{ $key }})'
                                        wire:loading.attr="disabled" class="btn btn-primary mt-2 md:rounded-none"
                                        type="button">
                                        <span wire:loading wire:target="deleteSuggestionInput({{ $key }})"
                                            class="loading loading-spinner"></span>
                                        <i wire:target="deleteSuggestionInput({{ $key }})"
                                            wire:loading.remove class="fa-solid fa-trash text-white"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-2 flex justify-end">
                    <button class="btn btn-primary" x-on:click="$dispatch('form-submitted')" wire:click="save"
                        wire:loading.attr="disabled"><span wire:target="save" wire:loading.remove>Submit</span>
                        <span wire:loading wire:target="save" class="loading loading-spinner"></span><span
                            wire:loading wire:target="save">Submitting</span>
                    </button>
                </div>

                <div class="z-9999 fixed inset-0 flex h-screen w-screen items-center justify-center bg-[rgba(0,0,0,0.5)]"
                    wire:target="save" wire:loading>
                    <div class="flex h-[100%] items-center justify-center">
                        <div class="">
                            <span class="loading loading-spinner text-primary loading-xl"></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

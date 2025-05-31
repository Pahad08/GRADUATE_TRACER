<div class="rounded-none px-3" x-data="{ isEmployed: '', isSubmit: false, showConfirmation: false }" x-on:graduate-created.window="isEmployed=''; isSubmit=false;"
    x-on:form-error.window="if(isSubmit){isSubmit=false;}">
    <div class="card lg:w-250 md:w-230 bg-base-200 border-base-300 mx-auto my-5 max-w-full border">
        <div class="card-body rounded-lg shadow-md">
            <div class="grid grid-cols-1">
                @foreach ($this->questionVisibility as $question)
                    @switch($question->question_key)
                        @case("ED-is_employed")
                            <div wire:key='{{ $question->question_key }}'>
                                <div>
                                    <label
                                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Are
                                        you presently employed? </label>
                                    <div @class(["flex gap-4", "mb-2" => $errors->has("form.is_employed")])>
                                        <label class="flex items-center">
                                            <input type="radio" x-model="isEmployed" @class([
                                                "radio border-base-300 bg-white",
                                                "radio-error" => $errors->has("form.is_employed"),
                                            ])
                                                value="yes" wire:model="form.is_employed">
                                            <span class="ml-2">Yes</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" x-model="isEmployed" @class([
                                                "radio border-base-300 bg-white",
                                                "radio-error" => $errors->has("form.is_employed"),
                                            ])
                                                value="no" wire:model="form.is_employed">
                                            <span class="ml-2">No</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" @class([
                                                "radio border-base-300 bg-white",
                                                "radio-error" => $errors->has("form.is_employed"),
                                            ]) x-model="isEmployed"
                                                wire:model="form.is_employed" value="never">
                                            <span class="ml-2">Never Employed</span>
                                        </label>
                                    </div>

                                    @if ($errors->has("form.is_employed"))
                                        <span class="text-error text-sm">{{ $errors->first("form.is_employed") }}</span>
                                    @endif
                                </div>

                                @if (isset($this->questionVisibility["ED-reason_for_not_employed"]))
                                    <template x-if="isEmployed !== 'yes' && isEmployed !== ''">
                                        <div wire:key='{{ $question->question_key }}'>
                                            <div class="divider"></div>

                                            <label
                                                class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                                Please state reason(s) why you are not yet employed. </label>
                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                @foreach ($unemployment_reasons as $key => $reason)
                                                    <label class="flex items-center" wire:key="{{ "reason-" . $key }}">
                                                        <input type="checkbox" class="checkbox border-base-300 bg-white"
                                                            value="{{ $reason }}"
                                                            wire:model="form.unemployment_reason.checkboxes">
                                                        <span class="ml-2">{{ $reason }}</span>
                                                    </label>
                                                @endforeach
                                            </div>

                                            <label class="mt-3 flex items-center">
                                                <input type="text" class="input w-full"
                                                    placeholder="Other reason(s), please specify"
                                                    wire:model="form.unemployment_reason.input">
                                            </label>

                                            @if ($errors->has("form.unemployment_reason.checkboxes") || $errors->has("form.unemployment_reason.input"))
                                                <div class="mt-1">
                                                    <p class="text-error">
                                                        {{ $errors->first("form.unemployment_reason.checkboxes") ?? $errors->first("form.unemployment_reason.input") }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </template>
                                @endif

                                <template x-if="isEmployed === 'yes' && isEmployed !== ''">
                                    <div x-data="{ isFirstJob: '', isRelated: '', is_curriculum_relevant_to_job: '' }" wire:key='1'
                                        x-on:graduate-created.window="isFirstJob='';isRelated='';is_curriculum_relevant_to_job='';">
                                        <div class="divider"></div>

                                        @if (isset($this->questionVisibility["ED-present_employment_status"]))
                                            <div>
                                                <label
                                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Present
                                                    Employment Status</label>
                                                <div class="flex flex-wrap gap-4">
                                                    @foreach ($employment_status as $key => $status)
                                                        <label class="items-center" wire:key='{{ "status-" . $key }}'>
                                                            <input type="radio" wire:model="form.present_employment_status"
                                                                value="{{ $status }}" @class([
                                                                    "radio border-base-300 bg-white",
                                                                    "radio-error" => $errors->has("form.present_employment_status"),
                                                                ])>
                                                            <span class="ml-2">{{ $status }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>

                                            @if ($errors->has("form.present_employment_status"))
                                                <div class="mt-1">
                                                    <p class="text-error">
                                                        {{ $errors->first("form.present_employment_status") }}
                                                    </p>
                                                </div>
                                            @endif

                                            <div class="divider"></div>
                                        @endif

                                        @if (isset($this->questionVisibility["ED-present_occupation"]))
                                            <div>
                                                <label
                                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Present
                                                    occupation (Use the following Phil. Standard Occupational Classification
                                                    (PSOC), 1992 classification)
                                                </label>
                                                <select wire:model ='form.occupation' @class([
                                                    "select w-full",
                                                    "select-error" => $errors->has("form.occupation"),
                                                ])>
                                                    <option selected disabled value="">Present occupation</option>
                                                    @foreach ($occupations as $key => $occupation)
                                                        <option value="{{ $occupation }}"
                                                            wire:key='{{ "occupation-" . $key }}'>
                                                            {{ $occupation }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            @if ($errors->has("form.occupation"))
                                                <div class="mt-1">
                                                    <p class="text-error">
                                                        {{ $errors->first("form.occupation") }}
                                                    </p>
                                                </div>
                                            @endif

                                            <div class="divider"></div>
                                        @endif

                                        @if (isset($this->questionVisibility["ED-company_name"]))
                                            <div>
                                                <label
                                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Name
                                                    of Company or Organization including address </label>
                                                <input @class([
                                                    "input w-full",
                                                    "input-error" => $errors->has("form.company_name"),
                                                ]) type="text"
                                                    wire:model="form.company_name">

                                                <p class="text-base-content my-1 italic">Note: Please enter full name of the
                                                    company.</p>
                                            </div>

                                            @if ($errors->has("form.company_name"))
                                                <div class="mt-1">
                                                    <p class="text-error">
                                                        {{ $errors->first("form.company_name") }}
                                                    </p>
                                                </div>
                                            @endif

                                            <div class="divider"></div>
                                        @endif

                                        @if (isset($this->questionVisibility["ED-line_of_busines"]))
                                            <div>
                                                <label
                                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Major
                                                    line of business of the company you are presently employed in.</label>
                                                <select wire:model="form.industry" @class([
                                                    "select w-full",
                                                    "select-error" => $errors->has("form.industry"),
                                                ])>
                                                    <option selected disabled value="">Major line of business</option>
                                                    @foreach ($industries as $key => $industry)
                                                        <option value="{{ $industry }}"
                                                            wire:key='{{ "industry-" . $key }}'>
                                                            {{ $industry }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            @if ($errors->has("form.industry"))
                                                <div class="mt-1">
                                                    <p class="text-error">
                                                        {{ $errors->first("form.industry") }}
                                                    </p>
                                                </div>
                                            @endif

                                            <div class="divider"></div>
                                        @endif

                                        @if (isset($this->questionVisibility["ED-place_of_work"]))
                                            <div>
                                                <label
                                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Place
                                                    of work</label>
                                                <div class="flex gap-4">
                                                    <label class="flex items-center">
                                                        <input type="radio" @class([
                                                            "radio border-base-300 bg-white",
                                                            "radio-error" => $errors->has("form.place_of_work"),
                                                        ])
                                                            wire:model='form.place_of_work' value="local">
                                                        <span class="ml-2">Local</span>
                                                    </label>
                                                    <label class="flex items-center">
                                                        <input type="radio" @class([
                                                            "radio bg-white",
                                                            "radio-error" => $errors->has("form.place_of_work"),
                                                        ])
                                                            wire:model='form.place_of_work' value="abroad">
                                                        <span class="ml-2">Abroad</span>
                                                    </label>
                                                </div>
                                            </div>

                                            @if ($errors->has("form.place_of_work"))
                                                <div class="mt-1">
                                                    <p class="text-error">
                                                        {{ $errors->first("form.place_of_work") }}
                                                    </p>
                                                </div>
                                            @endif

                                            <div class="divider"></div>
                                        @endif

                                        @if (isset($this->questionVisibility["ED-is_first_job"]))
                                            <div>
                                                <label
                                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Is
                                                    this your first job after college?</label>
                                                <div class="flex gap-4">
                                                    <label class="flex items-center">
                                                        <input type="radio" @class([
                                                            "radio border-base-300 bg-white",
                                                            "radio-error" => $errors->has("form.is_first_job"),
                                                        ])
                                                            wire:model="form.is_first_job" x-model="isFirstJob"
                                                            value="1">
                                                        <span class="ml-2">Yes</span>
                                                    </label>
                                                    <label class="flex items-center">
                                                        <input type="radio" @class([
                                                            "radio border-base-300 bg-white",
                                                            "radio-error" => $errors->has("form.is_first_job"),
                                                        ])
                                                            wire:model="form.is_first_job" x-model="isFirstJob"
                                                            value="0">
                                                        <span class="ml-2">No</span>
                                                    </label>
                                                </div>

                                                @if ($errors->has("form.is_first_job"))
                                                    <div class="mt-1">
                                                        <p class="text-error">
                                                            {{ $errors->first("form.is_first_job") }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>

                                            <template x-if="isFirstJob === '1' && isFirstJob !== ''">
                                                <div>
                                                    @if (isset($this->questionVisibility["ED-job_retention_reason"]))
                                                        <div class="divider"></div>

                                                        <div>
                                                            <label
                                                                class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">What
                                                                are your reason(s) for staying on the job?</label>
                                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                                @foreach ($reasons as $key => $reason)
                                                                    <label class="flex items-center"
                                                                        wire:key="{{ "reason-" . $key }}">
                                                                        <input type="checkbox"
                                                                            wire:model='form.job_retention.checkboxes'
                                                                            value="{{ $reason }}"
                                                                            class="checkbox border-base-300 bg-white">
                                                                        <span class="ml-2">{{ $reason }}</span>
                                                                    </label>
                                                                @endforeach
                                                            </div>

                                                            <div class="mt-3 flex items-center">
                                                                <input type="text" wire:model='form.job_retention.input'
                                                                    class="input w-full"
                                                                    placeholder="Other reason(s), please specify">
                                                            </div>

                                                            @if ($errors->has("form.job_retention.input") || $errors->has("form.job_retention.checkboxes"))
                                                                <div class="mt-1">
                                                                    <p class="text-error">
                                                                        {{ $errors->first("form.job_retention.input") ?? $errors->first("form.job_retention.checkboxes") }}
                                                                    </p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    @if (isset($this->questionVisibility["ED-is_related_to_course"]))
                                                        <div class="divider"></div>

                                                        <div>
                                                            <label
                                                                class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Is
                                                                your first job related to the course you took up in
                                                                college?</label>
                                                            <div class="flex gap-4">
                                                                <label class="flex items-center">
                                                                    <input type="radio" @class([
                                                                        "radio border-base-300 bg-white",
                                                                        "radio-error" => $errors->has("form.related_to_course"),
                                                                    ])
                                                                        wire:model="form.related_to_course"
                                                                        x-model="isRelated" value="1">
                                                                    <span class="ml-2">Yes</span>
                                                                </label>
                                                                <label class="flex items-center">
                                                                    <input type="radio" @class([
                                                                        "radio border-base-300 bg-white",
                                                                        "radio-error" => $errors->has("form.related_to_course"),
                                                                    ])
                                                                        wire:model="form.related_to_course"
                                                                        x-model="isRelated" value="0">
                                                                    <span class="ml-2">No</span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="divider" x-show="isRelated === '1' && isRelated !== ''"
                                                            x-transition>
                                                        </div>

                                                        @if (isset($this->questionVisibility["ED-job_acceptance_reason"]))
                                                            <template x-if="isRelated === '1' && isRelated !== ''">
                                                                <div>
                                                                    <label
                                                                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">What
                                                                        were your reasons for accepting the job?</label>
                                                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                                        @foreach ($reasons as $key => $reason)
                                                                            <label class="flex items-center"
                                                                                wire:key="{{ "reason-" . $key }}">
                                                                                <input type="checkbox"
                                                                                    wire:model='form.job_acceptance.checkboxes'
                                                                                    value="{{ $reason }}"
                                                                                    class="checkbox border-base-300 bg-white">
                                                                                <span
                                                                                    class="ml-2">{{ $reason }}</span>
                                                                            </label>
                                                                        @endforeach
                                                                    </div>

                                                                    <div class="mt-3 flex items-center">
                                                                        <input type="text"
                                                                            wire:model='form.job_acceptance.input'
                                                                            class="input w-full"
                                                                            placeholder="Other reason(s), please specify">
                                                                    </div>

                                                                    @if ($errors->has("form.job_acceptance.input") || $errors->has("form.job_acceptance.checkboxes"))
                                                                        <div class="mt-1">
                                                                            <p class="text-error">
                                                                                {{ $errors->first("form.job_acceptance.input") ?? $errors->first("form.job_acceptance.checkboxes") }}
                                                                            </p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </template>
                                                        @endif
                                                    @endif
                                                </div>
                                            </template>

                                            @if (isset($this->questionVisibility["ED-job_change_reason"]))
                                                <template x-if="isFirstJob === '0' && isFirstJob !== ''">
                                                    <div>
                                                        <div class="divider"></div>
                                                        <div>
                                                            <div>
                                                                <label
                                                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">What
                                                                    were your reason(s) for changing job?</label>
                                                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                                    @foreach ($reasons as $key => $reason)
                                                                        <label class="flex items-center"
                                                                            wire:key="{{ "reason-" . $key }}">
                                                                            <input type="checkbox"
                                                                                wire:model='form.job_change.checkboxes'
                                                                                class="checkbox border-base-300 bg-white"
                                                                                value="{{ $reason }}">
                                                                            <span class="ml-2">{{ $reason }}</span>
                                                                        </label>
                                                                    @endforeach
                                                                </div>

                                                                <div class="mt-3 flex items-center">
                                                                    <input type="text" wire:model='form.job_change.input'
                                                                        class="input w-full"
                                                                        placeholder="Other reason(s), please specify">
                                                                </div>

                                                                @if ($errors->has("form.job_change.input") || $errors->has("form.job_change.checkboxes"))
                                                                    <div class="mt-1">
                                                                        <p class="text-error">
                                                                            {{ $errors->first("form.job_change.input") ?? $errors->first("form.job_change.checkboxes") }}
                                                                        </p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="divider"></div>

                                                        <div>
                                                            <label
                                                                class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">How
                                                                long did you stay in your first job?</label>
                                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                                @foreach ($first_job_durations as $key => $reason)
                                                                    <label class="flex items-center"
                                                                        wire:key="{{ "first-job-duration-" . $key }}">
                                                                        <input type="radio"
                                                                            wire:model="form.first_job_duration"
                                                                            class="radio border-base-300 bg-white"
                                                                            value="{{ $reason }}">
                                                                        <span class="ml-2">{{ $reason }}</span>
                                                                    </label>
                                                                @endforeach
                                                            </div>

                                                            <div class="mt-3 flex items-center">
                                                                <input type="text" wire:model='form.first_job_duration'
                                                                    class="input w-full" placeholder="Others, please specify">
                                                            </div>

                                                            @if ($errors->has("form.first_job_duration"))
                                                                <div class="mt-1">
                                                                    <p class="text-error">
                                                                        {{ $errors->first("form.first_job_duration") }}
                                                                    </p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </template>
                                            @endif
                                            <div class="divider"></div>
                                        @endif

                                        @if (isset($this->questionVisibility["ED-first_job_search_method"]))
                                            <div>
                                                <label
                                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">How
                                                    did you find your first job?</label>
                                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                    @foreach ($first_job_sources as $key => $source)
                                                        <label class="flex items-center" wire:key='{{ "source-" . $key }}'>
                                                            <input type="checkbox" value="{{ $source }}"
                                                                class="checkbox border-base-300 bg-white"
                                                                wire:model='form.job_source.checkboxes'>
                                                            <span class="ml-2">{{ $source }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                                <div class="mt-3 flex items-center">
                                                    <input type="text" wire:model='form.job_source.input'
                                                        class="input w-full" placeholder="Others, please specify">
                                                </div>

                                                @if ($errors->has("form.job_source.input") || $errors->has("form.job_source.checkboxes"))
                                                    <div class="mt-1">
                                                        <p class="text-error">
                                                            {{ $errors->first("form.job_source.input") ?? $errors->first("form.job_source.checkboxes") }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="divider"></div>
                                        @endif

                                        @if (isset($this->questionVisibility["ED-first_job_search_duration"]))
                                            <div>
                                                <label
                                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">How
                                                    long did it take you to land your first job?</label>
                                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                    @foreach ($first_job_search_durations as $key => $duration)
                                                        <label class="flex items-center" wire:key='{{ "duration-" . $key }}'>
                                                            <input type="radio" wire:model="form.first_job_search_duration"
                                                                class="radio border-base-300 bg-white"
                                                                value="{{ $duration }}">
                                                            <span class="ml-2">{{ $key }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>

                                                <div class="mt-3 flex flex-col">
                                                    <label
                                                        class="text-neutral mb-2 font-semibold after:text-red-500 after:content-['*']">Others,
                                                        please specify</label>
                                                    <input type="text" wire:model='form.first_job_search_duration'
                                                        class="input w-full">
                                                </div>

                                                @if ($errors->has("form.first_job_search_duration"))
                                                    <div class="mt-1">
                                                        <p class="text-error">
                                                            {{ $errors->first("form.first_job_search_duration") }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="divider"></div>
                                        @endif

                                        @if (isset($this->questionVisibility["ED-first_job_position"]) ||
                                                isset($this->questionVisibility["ED-current_position"]))
                                            <div>
                                                <label
                                                    class="text-neutral mb-4 block text-sm font-semibold after:text-red-500 after:content-['*']">Job
                                                    Level Position</label>
                                                <div class="grid grid-cols-1 gap-2">
                                                    @if (isset($this->questionVisibility["ED-first_job_position"]))
                                                        <div>
                                                            <label class="text-neutral mb-2 block text-sm font-semibold">First
                                                                Job</label>
                                                            <div class="flex flex-col gap-4 md:flex-row">
                                                                @foreach ($job_levels as $key => $job_level)
                                                                    <label class="flex items-center"
                                                                        wire:key='{{ "job-level-" . $key }}'>
                                                                        <input type="radio"
                                                                            wire:model="form.first_job_level"
                                                                            @class([
                                                                                "radio border-base-300 bg-white",
                                                                                "radio-error" => $errors->has("form.first_job_level"),
                                                                            ])
                                                                            value="{{ $job_level }}">
                                                                        <span class="ml-2">{{ $job_level }}</span>
                                                                    </label>
                                                                @endforeach
                                                            </div>

                                                            @if ($errors->has("form.first_job_level"))
                                                                <div class="mt-1">
                                                                    <p class="text-error">
                                                                        {{ $errors->first("form.first_job_level") }}
                                                                    </p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    @if (isset($this->questionVisibility["ED-current_position"]))
                                                        <div>
                                                            <label
                                                                class="text-neutral mb-2 block text-sm font-semibold">Current
                                                                or Present Job</label>
                                                            <div class="flex flex-col gap-4 md:flex-row">
                                                                @foreach ($job_levels as $key => $job_level)
                                                                    <label class="flex items-center"
                                                                        wire:key='{{ "job-level-" . $key }}'>
                                                                        <input type="radio"
                                                                            wire:model="form.current_job_level"
                                                                            @class([
                                                                                "radio border-base-300 bg-white",
                                                                                "radio-error" => $errors->has("form.first_job_level"),
                                                                            ])
                                                                            value="{{ $job_level }}">
                                                                        <span class="ml-2">{{ $job_level }}</span>
                                                                    </label>
                                                                @endforeach
                                                            </div>

                                                            @if ($errors->has("form.current_job_level"))
                                                                <div class="mt-1">
                                                                    <p class="text-error">
                                                                        {{ $errors->first("form.current_job_level") }}
                                                                    </p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="divider"></div>
                                        @endif

                                        @if (isset($this->questionVisibility["ED-initial_gross"]))
                                            <div>
                                                <label
                                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">What
                                                    is your initial gross monthly earning in your first job after
                                                    college?</label>
                                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                    @foreach ($salaryRanges as $key => $range)
                                                        <label class="flex items-center" wire:key='{{ "range-" . $key }}'>
                                                            <input type="radio" wire:model="form.first_job_initial_gross"
                                                                @class([
                                                                    "radio border-base-300 bg-white",
                                                                    "radio-error" => $errors->has("form.first_job_initial_gross"),
                                                                ]) value="{{ $range }}">
                                                            <span class="ml-2">{{ $key }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>

                                                @if ($errors->has("form.first_job_initial_gross"))
                                                    <div class="mt-1">
                                                        <p class="text-error">
                                                            {{ $errors->first("form.first_job_initial_gross") }}
                                                        </p>
                                                    </div>
                                                @endif

                                            </div>

                                            <div class="divider"></div>
                                        @endif

                                        @if (isset($this->questionVisibility["ED-curriculum_is_relevant"]))
                                            <div>
                                                <label
                                                    class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                                    Was the curriculum you had in college relevant to your
                                                    first job?</label>
                                                <div class="flex gap-4">
                                                    <label class="flex items-center">
                                                        <input type="radio" x-model="is_curriculum_relevant_to_job"
                                                            @class([
                                                                "radio border-base-300 bg-white",
                                                                "radio-error" => $errors->has("form.is_curriculum_relevant_to_job"),
                                                            ]) value="1"
                                                            wire:model="form.is_curriculum_relevant_to_job">
                                                        <span class="ml-2">Yes</span>
                                                    </label>
                                                    <label class="flex items-center">
                                                        <input type="radio" x-model="is_curriculum_relevant_to_job"
                                                            @class([
                                                                "radio border-base-300 bg-white",
                                                                "radio-error" => $errors->has("form.is_curriculum_relevant_to_job"),
                                                            ]) value="0"
                                                            wire:model="form.is_curriculum_relevant_to_job">
                                                        <span class="ml-2">No</span>
                                                    </label>
                                                </div>

                                                @if ($errors->has("form.is_curriculum_relevant_to_job"))
                                                    <div class="mt-1">
                                                        <p class="text-error">
                                                            {{ $errors->first("form.is_curriculum_relevant_to_job") }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        @if (isset($this->questionVisibility["ED-skill_in_college"]))
                                            <template
                                                x-if="is_curriculum_relevant_to_job === '1' && is_curriculum_relevant_to_job !== ''">
                                                <div>
                                                    <div class="divider"></div>
                                                    <label
                                                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">What
                                                        competencies learned in college did you find very useful in your
                                                        first job?</label>
                                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                        @foreach ($skills as $key => $skill)
                                                            <label class="flex items-center"
                                                                wire:key="{{ "skill-" . $key }}">
                                                                <input type="checkbox" wire:model='form.skills.checkboxes'
                                                                    value="{{ $skill }}"
                                                                    class="checkbox border-base-300 bg-white">
                                                                <span class="ml-2">{{ $skill }}</span>
                                                            </label>
                                                        @endforeach
                                                    </div>

                                                    <div class="mt-3 flex items-center">
                                                        <input type="text" wire:model='form.skills.input'
                                                            class="input w-full" placeholder="Other, please specify">
                                                    </div>

                                                    @if ($errors->has("form.skills.input") || $errors->has("form.skills.checkboxes"))
                                                        <div class="mt-1">
                                                            <p class="text-error">
                                                                {{ $errors->first("form.skills.input") ?? $errors->first("form.skills.checkboxes") }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </template>
                                        @endif
                                    </div>
                                </template>
                            </div>
                        @break

                        @case("ED-suggestions")
                            <div wire:key='{{ $question->question_key }}'>
                                <div class="divider"></div>

                                <div>
                                    <label class="text-neutral font-semibold] block text-sm">
                                        List down suggestions to further improve your course curriculum
                                    </label>
                                    @foreach ($form->suggestions as $key => $row)
                                        <div class="{{ !$loop->first ? "mt-2" : "" }} grid grid-cols-3 items-end gap-y-2"
                                            wire:key="{{ "suggestion-" . $key }}">
                                            <div class="col-span-2">
                                                <input type="text" wire:model="form.suggestions.{{ $key }}"
                                                    @class([
                                                        "input w-full rounded-none",
                                                        "input-error" => $errors->has("form.suggestions." . $key),
                                                    ])>
                                            </div>

                                            <div class="col-span-1">
                                                @if ($loop->first)
                                                    <button wire:click='addSuggestionInput' wire:loading.attr="disabled"
                                                        class="btn btn-secondary mt-2 rounded-none" type="button">
                                                        <span wire:loading wire:target="addSuggestionInput"
                                                            class="loading loading-spinner"></span>
                                                        <i wire:target="addSuggestionInput" wire:loading.remove
                                                            class="fa-solid fa-plus"></i>
                                                    </button>
                                                @else
                                                    <button wire:click='deleteSuggestionInput({{ $key }})'
                                                        wire:loading.attr="disabled"
                                                        class="btn btn-error mt-2 md:rounded-none" type="button">
                                                        <span wire:loading
                                                            wire:target="deleteSuggestionInput({{ $key }})"
                                                            class="loading loading-spinner"></span>
                                                        <i wire:target="deleteSuggestionInput({{ $key }})"
                                                            wire:loading.remove class="fa-solid fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
                                                    <span
                                                        class="text-error mt-2 text-sm">{{ $errors->first("form.custom_questions.$fieldKey") }}</span>
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
                                                    <span
                                                        class="text-error mt-2 text-sm">{{ $errors->first("form.custom_questions.$fieldKey") }}
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <div>
                                                <select
                                                    class="select {{ $errors->has("form.custom_questions.$fieldKey") ? "select-error" : "" }} w-full"
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
                                                    <span
                                                        class="text-error mt-2 text-sm">{{ $errors->first("form.custom_questions.$fieldKey") }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        <div>
                                            <input type="{{ $question->question->type }}" @class([
                                                "input w-full",
                                                "input-error" => $errors->has("form.custom_questions.$fieldKey"),
                                            ])
                                                wire:model="form.custom_questions.{{ $fieldKey }}">

                                            @if ($errors->has("form.custom_questions.$fieldKey"))
                                                <span
                                                    class="text-error mt-2 text-sm">{{ $errors->first("form.custom_questions.$fieldKey") }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif
                    @endswitch
                @endforeach

                <div class="join mt-4 justify-end">
                    <button class="join-item btn btn-secondary"
                        x-on:click="activeTab = 'tracer-components.studies-information';window.scrollTo({ top: 0, behavior: 'smooth' })"><i
                            class="fa-solid fa-arrow-left"></i> Previous</button>
                    <button x-on:click="showConfirmation = true;" class="btn btn-primary join-item"><i
                            class="fa-solid fa-floppy-disk"></i>
                        Submit
                    </button>
                </div>

                <div x-show="isSubmit"
                    class="z-9999 fixed inset-0 flex h-screen w-screen items-center justify-center bg-[rgba(0,0,0,0.5)]">
                    <div class="flex h-[100%] items-center justify-center">
                        <div class="">
                            <span class="loading loading-spinner text-primary loading-xl"></span>
                        </div>
                    </div>
                </div>

                <div class="modal" :class="showConfirmation ? 'modal-open' : ''"
                    x:on-display-summary="showConfirmation = true;" role="dialog">
                    <div class="modal-box">
                        <h3 class="text-lg font-bold">Submit Graduate</h3>
                        <p class="py-4">Are you sure you want to submit this graduate? This action cannot be
                            undone.
                        </p>
                        <div class="modal-action mt-0">
                            <button class="btn btn-soft" x-on:click="showConfirmation = false">Close</button>
                            <button class="btn btn-success"
                                x-on:click="$dispatch('form-submitted'); isSubmit = true; showConfirmation = false;"><span><i
                                        class="fa-solid fa-floppy-disk"></i> Submit</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

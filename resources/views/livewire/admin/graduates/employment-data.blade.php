<!-- Employment Status Section -->
<div class="card bg-base-100 border-base-300 w-full border shadow-sm">
    <div class="card-body gap-0">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="flex items-center gap-2">
                <span class="text-neutral font-bold">Is presently employed:</span>
                <span @class([
                    "badge badge-sm",
                    "badge-success" => optional($employment_data)->is_employed === "yes",
                    "badge-error" => optional($employment_data)->is_employed !== "yes",
                ])>
                    {{ ucfirst(optional($employment_data)->is_employed) }}
                </span>
            </div>
        </div>

        @if (optional($employment_data)->is_employed === "yes")
            @php
                $first_job_method = $job_details->where("type", "first_job_search_method");
                $first_job_search_duration = $job_details->where("type", "first_job_search_duration")->first();
                $first_job_salary = $job_details->where("type", "first_job_salary_range")->first();
                $skills = $job_details->where("type", "college_skill");
            @endphp
            <div class="divider text-neutral-content text-xs">
                <span class="text-neutral">Employment Details</span>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <span class="text-neutral mb-2 font-bold">Present Employment Status:</span>
                    <p>{{ $employment_data->employmentDetails->present_employment_status }}</p>
                </div>

                <div>
                    <span class="text-neutral mb-2 font-bold">Occupation:</span>
                    <p>{{ $employment_data->employmentDetails->occupation }}</p>
                </div>

                <div>
                    <span class="text-neutral mb-2 font-bold">Name of Company or Organization including address:</span>
                    <p>{{ $employment_data->employmentDetails->company_name }}</p>
                </div>

                <div>
                    <span class="text-neutral mb-2 font-bold">Major line of business of the company:</span>
                    <p>{{ $employment_data->employmentDetails->industry }}</p>
                </div>

                <div>
                    <span class="text-neutral mb-2 font-bold">Place of work:</span>
                    <p>{{ $employment_data->employmentDetails->work_location }}</p>
                </div>

                <div>
                    <span class="text-neutral mb-2 font-bold">Is first job after college:</span>
                    <p>
                        {{ $employment_details->is_first_job === 1 ? "Yes" : "No" }}</p>
                </div>
            </div>

            <div class="divider text-neutral-content text-xs">
                <span class="text-neutral">First Job Information</span>
            </div>

            @if ($employment_details->is_first_job === 0)
                @php
                    $job_change_reasons = $graduate_reasons->where("type", "job_change_reason");
                    $first_job_duration = $job_details->where("type", "first_job_duration")->first();
                @endphp

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <p class="text-neutral mb-2 font-bold">Reasons for changing job</p>
                        <ul class="list-inside list-disc">
                            @foreach ($job_change_reasons as $reason)
                                <li @class(["text-md", "mt-1" => !$loop->first])>{{ $reason->reason }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <span class="text-neutral mb-2 font-bold">First Job Duration:</span>
                        <p>{{ $first_job_duration->description }}</p>
                    </div>

                    <div>
                        <p class="text-neutral mb-2 font-bold">First Job Search</p>
                        <ul class="list-inside list-disc">
                            @foreach ($first_job_method as $method)
                                <li @class(["text-md", "mt-1" => !$loop->first])>{{ $method->description }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <span class="text-neutral mb-2 font-bold">First Job Search Duration:</span>
                        <p>{{ $first_job_search_duration->description }}</p>
                    </div>

                    <div>
                        <span class="text-neutral mb-2 font-bold">Initial Gross Monthly Earning in First Job:</span>
                        <p>₱{{ $first_job_salary->description }}</p>
                    </div>

                    <div>
                        <span class="text-neutral mb-2 font-bold">Was the curriculum in college relevant to the first
                            job:</span>
                        <p>{{ $employment_details->is_curriculum_relevant_to_job === 1 ? "Yes" : "No" }}</p>
                    </div>

                    @if ($employment_details->is_curriculum_relevant_to_job === 1)
                        <div>
                            <p class="text-neutral mb-2 font-bold">Competencies learned in college:</p>
                            @foreach ($skills as $skill)
                                <li @class(["text-md", "mt-1" => !$loop->first])>{{ $skill->description }}</li>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            @if ($employment_details->is_first_job === 1)
                @php
                    $job_change_reasons = $graduate_reasons->where("type", "job_retention_reason");
                @endphp

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <p class="text-neutral mb-2 font-bold">Reasons for staying on the job</p>
                        <ul class="list-inside list-disc">
                            @foreach ($job_change_reasons as $reason)
                                <li @class(["text-md", "mt-1" => !$loop->first])>{{ $reason->reason }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <span class="text-neutral mb-2 font-bold">Was First job related To The Course Took Up in
                            College:</span>
                        <p>{{ $employment_details->is_related_to_course === 1 ? "Yes" : "No" }}</p>
                    </div>

                    @if ($employment_details->is_related_to_course === 1)
                        @php
                            $job_acceptance_reasons = $graduate_reasons->where("type", "job_acceptance_reason");
                        @endphp
                        <div>
                            <p class="text-neutral mb-2 font-bold">Reasons for accepting the the job</p>
                            <ul class="list-inside list-disc">
                                @foreach ($job_acceptance_reasons as $reason)
                                    <li @class(["text-md", "mt-1" => !$loop->first])>{{ $reason->reason }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <p class="text-neutral mb-2 font-bold">First Job Search</p>
                        <ul class="list-inside list-disc">
                            @foreach ($first_job_method as $method)
                                <li @class(["text-md", "mt-1" => !$loop->first])>{{ $method->description }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <span class="text-neutral mb-2 font-bold">First Job Search Duration:</span>
                        <p>{{ $first_job_search_duration->description }}</p>
                    </div>

                    <div>
                        <span class="text-neutral mb-2 font-bold">Initial Gross Monthly Earning in First Job:</span>
                        <p>₱{{ $first_job_salary->description }}</p>
                    </div>

                    <div>
                        <span class="text-neutral mb-2 font-bold">Was the curriculum in college relevant to the first
                            job:</span>
                        <p>{{ $employment_details->is_curriculum_relevant_to_job === 1 ? "Yes" : "No" }}</p>
                    </div>

                    @if ($employment_details->is_curriculum_relevant_to_job === 1)
                        <div>
                            <p class="text-neutral mb-2 font-bold">Competencies learned in college:</p>
                            @foreach ($skills as $skill)
                                <li @class(["text-md", "mt-1" => !$loop->first])>{{ $skill->description }}</li>
                            @endforeach
                        </div>
                    @endif
                </div>

            @endif

            <div class="divider text-neutral-content text-xs">
                <span class="text-neutral">Job Level Position</span>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <span class="text-neutral mb-2 font-bold">First Job:</span>
                    <p>{{ $employment_details->first_job_level }}</p>
                </div>

                <div>
                    <span class="text-neutral mb-2 font-bold">Current or Present Job:</span>
                    <p>{{ $employment_details->current_job_level }}</p>
                </div>
            </div>
        @else
            <div class="divider text-neutral-content text-xs">
                <span class="text-neutral">Unemployment Reasons</span>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <div class="text-neutral mb-2 font-bold">Reason for Not Being Employed</div>
                    @php
                        $unemployment_reasons = $reasons->where("type", "unemployment_reason");
                    @endphp
                    <ul class="list-inside list-disc">
                        @foreach ($unemployment_reasons as $reason)
                            <li @class(["text-md", "mt-1" => !$loop->first])>{{ $reason->reason }}</li>
                        @endforeach
                    </ul>
                </div>

                {{-- <div>
                    <span class="text-neutral text-sm">Suggestions for Employment Assistance:</span>
                    <div class="font-semibold">
                        {{ $graduate->suggestion_for_employment ?? "-" }}
                    </div>
                </div> --}}
            </div>
        @endif

        @if (count($custom_question_responses) > 0)
            <div class="divider text-neutral-content text-xs"><span class="text-neutral">Additional Information</span>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach ($custom_question_responses as $response)
                    <div>
                        <span
                            class="text-neutral mb-2 text-sm font-bold">{{ ucfirst($response->customQuestion->label) }}:</span>
                        <p class="text-sm">{{ $response->response_value }}</p>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

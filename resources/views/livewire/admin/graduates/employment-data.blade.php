<!-- Employment Status Section -->
<div class="card bg-base-100 border-base-300 w-full border shadow-sm">
    <div class="card-body gap-4">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="flex items-center gap-2">
                <span class="text-neutral font-bold">Is presently employed:</span>
                <span @class([
                    "badge badge-sm",
                    "badge-success" => $employment_data->is_employed === "yes",
                    "badge-error" => $employment_data->is_employed !== "yes",
                ])>
                    {{ ucfirst($employment_data->is_employed) }}
                </span>
            </div>
        </div>


        <div class="divider text-neutral-content text-xs">
            <span class="text-neutral">Additional Information</span>
        </div>
        @if ($employment_data->is_employed === "yes")
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <span class="text-neutral font-bold">Present Employment Status:</span>
                    <p>{{ $employment_data->employmentDetails->present_employment_status }}</p>
                </div>

                <div>
                    <span class="text-neutral font-bold">Occupation:</span>
                    <p>{{ $employment_data->employmentDetails->occupation }}</p>
                </div>

                <div>
                    <span class="text-neutral font-bold">Name of Company or Organization including address:</span>
                    <p>{{ $employment_data->employmentDetails->company_name }}</p>
                </div>

                <div>
                    <span class="text-neutral font-bold">Major line of business of the company:</span>
                    <p>{{ $employment_data->employmentDetails->industry }}</p>
                </div>

                <div>
                    <span class="text-neutral font-bold">Place of work:</span>
                    <p>{{ $employment_data->employmentDetails->work_location }}</p>
                </div>

                <div>
                    <span class="text-neutral font-bold">Is first job after college:</span>
                    <p>
                        {{ $employment_data->employmentDetails->is_first_job === 1 ? "Yes" : "No" }}</p>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <div class="text-neutral mb-2 font-bold">Reason for Not Being Employed</div>
                    @php
                        $reasons = $graduate->reason->where("type", "unemployment_reason");
                    @endphp
                    <ul class="list-inside list-disc">
                        @foreach ($reasons as $reason)
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

    </div>
</div>

<div class="card bg-base-100 border-base-300 w-full border shadow-sm">
    <div class="card-body gap-0">
        <div>
            <h2 class="card-title text-2xl">{{ $graduate->f_name ?? "" }} {{ $graduate->l_name }}</h2>
        </div>

        <div class="divider text-neutral-content text-xs"><span class="text-neutral">Personal Information</span></div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <span class="text-neutral mb-2 font-bold">Sex:</span>
                <p>{{ $graduate->sex }}</p>
            </div>
            <div>
                <span class="text-neutral mb-2 font-bold">Civil Status:</span>
                <p>{{ $graduate->civil_status }}</p>
            </div>
            <div>
                <span class="text-neutral mb-2 font-bold">Birthday:</span>
                <p>{{ date("F j, Y", strtotime($graduate->birthdate)) }}</p>
            </div>
        </div>

        <div class="divider text-neutral-content text-xs"><span class="text-neutral">Address Information</span></div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <span class="text-neutral mb-2 font-bold">Permanent Address:</span>
                <p>{{ $graduate->permanent_address }}</p>
            </div>
            <div>
                <span class="text-neutral mb-2 font-bold">Location of Residence:</span>
                <p>{{ $graduate->location_of_residence }}</p>
            </div>
            <div>
                <span class="text-neutral mb-2 font-bold">Region:</span>
                <p>{{ $graduate->region->region_name ?? "-" }}</p>
            </div>
            <div>
                <span class="text-neutral mb-2 font-bold">Province:</span>
                <p>{{ $graduate->province->province_name ?? "-" }}</p>
            </div>
        </div>

        <div class="divider text-neutral-content text-xs"><span class="text-neutral">Contact Information</span></div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <span class="text-neutral mb-2 font-bold">Email Address:</span>
                <p>{{ $graduate->email_address }}</p>
            </div>
            <div>
                <span class="text-neutral mb-2 font-bold">Contact Number:</span>
                <p>{{ $graduate->contact_number }}</p>
            </div>
        </div>

        @if (count($custom_question_responses) > 0)
            <div class="divider text-neutral-content text-xs"><span class="text-neutral">Additional Information</span>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach ($custom_question_responses as $response)
                    <div>
                        <span
                            class="text-neutral mb-2 font-bold">{{ ucfirst($response->customQuestion->label) }}:</span>
                        <p>{{ $response->response_value }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

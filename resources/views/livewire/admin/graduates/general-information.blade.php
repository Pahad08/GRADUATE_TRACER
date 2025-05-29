<div class="card w-full">
    <div class="card-body gap-0">
        <div>
            <h2 class="card-title text-2xl">{{ ucfirst($graduate->f_name ?? "") }} {{ ucfirst($graduate->l_name ?? "") }}
                {{ ucfirst($graduate->name_extension ?? "") }}
            </h2>
        </div>

        <div class="divider text-neutral-content text-xs"><span class="text-neutral">Personal Information</span></div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <span class="text-neutral mb-2 font-bold">Sex:</span>
                <p>{{ ucfirst($graduate->sex ?? "") }}</p>
            </div>
            <div>
                <span class="text-neutral mb-2 font-bold">Civil Status:</span>
                <p>{{ ucfirst($graduate->civil_status ?? "") }}</p>
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
                <p>{{ ucfirst($graduate->permanent_address ?? "") }}</p>
            </div>
            <div>
                <span class="text-neutral mb-2 font-bold">Location of Residence:</span>
                <p>{{ ucfirst($graduate->location_of_residence ?? "") }}</p>
            </div>
            <div>
                <span class="text-neutral mb-2 font-bold">Region:</span>
                <p>{{ ucfirst($graduate->region ?? "-") }}</p>
            </div>
            <div>
                <span class="text-neutral mb-2 font-bold">Province:</span>
                <p>{{ ucfirst($graduate->province ?? "-") }}</p>
            </div>
        </div>

        <div class="divider text-neutral-content text-xs"><span class="text-neutral">Contact Information</span></div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <span class="text-neutral mb-2 font-bold">Email Address:</span>
                <p>{{ ucfirst($graduate->email_address ?? "") }}</p>
            </div>
            <div>
                <span class="text-neutral mb-2 font-bold">Contact Number:</span>
                <p>{{ ucfirst($graduate->contact_number ?? "") }}</p>
            </div>
        </div>

        @if (count($custom_question_responses) > 0)
            <div class="divider text-neutral-content text-xs"><span class="text-neutral">Additional Information</span>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach ($custom_question_responses as $response)
                    <div>
                        <span
                            class="text-neutral mb-2 font-bold">{{ ucfirst($response->customQuestion->label ?? "") }}:</span>
                        <p>{{ ucfirst($response->response_value) }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

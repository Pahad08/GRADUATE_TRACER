<div class="p-5">
    <div class="card border-1 border-base-300 bg-base-100 shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-neutral font-bold">Professional or work-related training programs</h3>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr class="border-base-300">
                            <th>Title of Training</th>
                            <th>Duration and Credits Earned</th>
                            <th>Name of Training Institution</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($graduate->training as $training)
                            <tr>
                                <td>{{ ucfirst($training->training_name ?? "") }}</td>
                                <td>{{ ucfirst($training->duration_and_credits_earned ?? "") }}</td>
                                <td>{{ ucfirst($training->training_institution ?? "") }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-1 border-base-300 bg-base-100 mt-5 shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-neutral font-bold">Reason for pursuing advance studies</h3>
            <div class="grid gap-3 overflow-x-auto md:grid-cols-2">
                @php
                    $reasons = $graduate->reason->where("type", "pursue_study_reason");
                @endphp
                <div>
                    <p class="text-base-content mb-2 text-sm font-semibold opacity-70">Reason</p>
                    <ul class="list-inside list-disc">
                        @foreach ($reasons as $reason)
                            <li @class(["text-md", "mt-1" => !$loop->first])>{{ ucfirst($reason->reason ?? "") }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if (count($custom_question_responses) > 0)
        <div class="divider text-neutral-content text-xs"><span class="text-neutral">Additional Information</span>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @foreach ($custom_question_responses as $response)
                <div>
                    <span
                        class="text-neutral mb-2 text-sm font-bold">{{ ucfirst($response->customQuestion->label ?? "") }}:</span>
                    <p class="text-sm">{{ ucfirst($response->response_value ?? "") }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>

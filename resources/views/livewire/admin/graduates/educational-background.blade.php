<div>
    @if (count($educational_backgrounds) > 0)
        <div class="flex flex-col gap-3">
            <div class="card border-1 border-base-300 bg-base-100 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="text-neutral font-bold">Baccalaureate Degree</h3>
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Degree & Specialization</th>
                                    <th class="whitespace-nowrap">College/University</th>
                                    <th class="whitespace-nowrap">Year Graduated</th>
                                    <th class="whitespace-nowrap">Honors Received</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($educational_backgrounds as $background)
                                    <tr>
                                        <td class="whitespace-nowrap">{{ $background->degree->degree_name }}</td>
                                        <td class="whitespace-nowrap">{{ $background->university->university_name }}
                                        </td>
                                        <td class="whitespace-nowrap">{{ $background->year_graduated }}</td>
                                        <td class="flex gap-2 whitespace-nowrap">
                                            @php
                                                $colors = [
                                                    "primary",
                                                    "secondary",
                                                    "accent",
                                                    "info",
                                                    "success",
                                                    "warning",
                                                    "error",
                                                ];
                                            @endphp
                                            @foreach ($background->honor as $honor)
                                                <span
                                                    class="badge badge-sm badge-{{ $colors[array_rand($colors)] }} badge-neutral">{{ $honor->honor }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div @class([
        "flex flex-col gap-3",
        "mt-3" => count($educational_backgrounds) > 0,
    ])>
        <div class="card border-1 border-base-300 bg-base-100 shadow-sm">
            <div class="card-body p-4">
                <h3 class="text-neutral font-bold">Training/Advance Studies</h3>
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">Title of Training</th>
                                <th class="whitespace-nowrap">Duration and Credits Earned</th>
                                <th class="whitespace-nowrap">Name of Training Institution</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainings as $key => $training)
                                <tr>
                                    <td class="whitespace-nowrap">
                                        {{ $training->training_name }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        {{ $training->duration_and_credits_earned }}</td>
                                    <td class="whitespace-nowrap">
                                        {{ $training->training_institution }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-1 border-base-300 bg-base-100 mt-6 shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-neutral font-bold">Reasons for taking the course or pursuing degree</h3>
            <div class="grid gap-3 overflow-x-auto md:grid-cols-2">
                @php
                    $undergraduate_reasons = $graduate_reasons->where("degree_level", "undergraduate");
                    $graduate_reasons = $graduate_reasons->where("degree_level", "graduate");
                @endphp
                @if (count($undergraduate_reasons) > 0)
                    <div>
                        <p class="text-base-content mb-2 text-sm font-semibold opacity-70">Undergraduates</p>
                        <ul class="list-inside list-disc">
                            @foreach ($undergraduate_reasons as $reason)
                                <li @class(["text-md", "mt-1" => !$loop->first])>{{ $reason->reason }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (count($graduate_reasons) > 0)
                    <div>
                        <p class="text-base-content mb-2 text-sm font-semibold">Graduates</p>
                        <ul class="list-inside list-disc">
                            @foreach ($graduate_reasons as $reason)
                                <li @class(["text-md", "mt-1" => !$loop->first])>{{ $reason->reason }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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
                        class="text-neutral mb-2 text-sm font-bold">{{ ucfirst($response->customQuestion->label) }}:</span>
                    <p class="text-sm">{{ $response->response_value }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>

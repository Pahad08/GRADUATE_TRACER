<div class="p-5">
    @if (count($educational_backgrounds) > 0)
        <div class="flex flex-col gap-3">
            <div class="card bg-base-100 border-base-300 border shadow-sm">
                <div class="card-body p-4">
                    <h3 class="text-neutral font-bold">Baccalaureate Degree</h3>
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr class="border-base-300">
                                    <th class="whitespace-nowrap">Degree & Specialization</th>
                                    <th class="whitespace-nowrap">College/University</th>
                                    <th class="whitespace-nowrap">Year Graduated</th>
                                    <th class="whitespace-nowrap">Honors Received</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($educational_backgrounds as $background)
                                    <tr>
                                        <td class="whitespace-nowrap">
                                            {{ ucfirst($background->degree ?? "Error fetching data") }}
                                        </td>
                                        <td class="whitespace-nowrap">
                                            {{ ucfirst($background->hei ?? "Error fetching data") }}
                                        </td>
                                        <td class="whitespace-nowrap">
                                            {{ $background->academicYear->academicYear ?? "" }}</td>
                                        <td class="flex gap-2 whitespace-nowrap">
                                            @if ($background->honor)
                                                @foreach ($background->honor as $honor)
                                                    <span
                                                        class="badge badge-sm badge-soft">{{ ucfirst($honor->honor) }}</span>
                                                @endforeach
                                            @endif
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
        "mt-5" => count($educational_backgrounds) > 0,
    ])>
        <div class="card bg-base-100 border-base-300 border shadow-sm">
            <div class="card-body p-4">
                <h3 class="text-neutral font-bold">Training/Advance Studies</h3>
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr class="border-base-300">
                                <th class="whitespace-nowrap">Examination Name</th>
                                <th class="whitespace-nowrap">Date Taken</th>
                                <th class="whitespace-nowrap">Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($examinations as $key => $examination)
                                <tr>
                                    <td class="whitespace-nowrap">
                                        {{ ucfirst($examination->name_of_examination) }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        {{ $examination->date_taken }}</td>
                                    <td class="whitespace-nowrap">
                                        {{ ucfirst($examination->rating) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-base-100 border-base-300 mt-5 border shadow-sm">
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
                                <li @class(["text-md", "mt-1" => !$loop->first])>{{ ucfirst($reason->reason) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (count($graduate_reasons) > 0)
                    <div>
                        <p class="text-base-content mb-2 text-sm font-semibold">Graduates</p>
                        <ul class="list-inside list-disc">
                            @foreach ($graduate_reasons as $reason)
                                <li @class(["text-md", "mt-1" => !$loop->first])>{{ ucfirst($reason->reason) }}</li>
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

        <div class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-2">
            @foreach ($custom_question_responses as $response)
                <div>
                    <span
                        class="text-neutral mb-2 text-sm font-bold">{{ ucfirst($response->customQuestion->label) }}:</span>
                    <p class="text-sm">{{ ucfirst($response->response_value) }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>

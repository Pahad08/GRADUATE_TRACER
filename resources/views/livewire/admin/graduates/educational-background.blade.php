<div>
    @if (count($graduate->educationalBackground) > 0)
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
                                @foreach ($graduate->educationalBackground as $background)
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
        "mt-3" => count($graduate->educationalBackground) > 0,
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
                            @foreach ($graduate->training as $key => $training)
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
                    $undergraduate_level = $graduate->reasonForCourse->where("degree_level", "undergraduate");
                    $graduate_level = $graduate->reasonForCourse->where("degree_level", "graduate");
                @endphp
                @if (count($undergraduate_level) > 0)
                    <div>
                        <p class="text-base-content mb-2 text-sm font-semibold opacity-70">Undergraduates</p>
                        <ul class="list-inside list-disc">
                            @foreach ($undergraduate_level as $level)
                                <li @class(["text-md", "mt-1" => !$loop->first])>{{ $level->reason }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (count($graduate_level) > 0)
                    <div>
                        <p class="text-base-content mb-2 text-sm font-semibold">Graduates</p>
                        <ul class="list-inside list-disc">
                            @foreach ($graduate_level as $level)
                                <li @class(["text-md", "mt-1" => !$loop->first])>{{ $level->reason }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

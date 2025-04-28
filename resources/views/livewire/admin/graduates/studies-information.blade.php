<div>
    <div class="card border-1 border-base-300 bg-base-100 shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-neutral font-bold">Professional or work-related training programs</h3>
            {{-- <div class="grid grid-cols-3 gap-3 overflow-x-auto">
                @foreach ($graduate->training as $training)
                    <div>
                        @if ($loop->first)
                            <p class="text-base-content mb-2 text-sm font-semibold">Title of Training</p>
                        @endif
                        <p class="text-md">{{ $training->training_name }}</p>
                    </div>

                    <div>
                        @if ($loop->first)
                            <p class="text-base-content mb-2 text-sm font-semibold">Duration and Credits Earned</p>
                        @endif
                        <p class="text-md">{{ $training->duration_and_credits_earned }}
                        </p>
                    </div>

                    <div>
                        @if ($loop->first)
                            <p class="text-base-content mb-2 text-sm font-semibold">
                                Name of Training Institution</p>
                        @endif
                        <p class="text-md">{{ $training->training_institution }}</p>
                    </div>
                @endforeach
            </div> --}}
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title of Training</th>
                            <th>Duration and Credits Earned</th>
                            <th>Name of Training Institution</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($graduate->training as $training)
                            <tr>
                                <td>{{ $training->training_name }}</td>
                                <td>{{ $training->duration_and_credits_earned }}
                                </td>
                                <td>{{ $training->training_institution }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-1 border-base-300 bg-base-100 mt-6 shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-neutral font-bold">Reason for pursuing advance studies</h3>
            <div class="grid gap-3 overflow-x-auto md:grid-cols-2">
                @php
                    $reasons = $graduate->reason->where("type", "pursue_study_reason");
                @endphp
                <div>
                    <p class="text-base-content mb-2 text-sm font-semibold opacity-70">Undergraduates</p>
                    <ul class="list-inside list-disc">
                        @foreach ($reasons as $reason)
                            <li @class(["text-md", "mt-1" => !$loop->first])>{{ $reason->reason }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

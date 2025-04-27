<div>
    <div class="card border-1 border-base-300 bg-base-100 shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-neutral font-bold">Professional or work-related training programs</h3>
            <div class="grid grid-cols-3 gap-3 overflow-x-auto">
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
            </div>
        </div>
    </div>

    <div class="card border-1 border-base-300 bg-base-100 mt-6 shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-neutral font-bold">Reason for pursuing advance studies</h3>
            <div class="grid gap-3 overflow-x-auto md:grid-cols-2">
                @php
                    $undergraduate_level = $graduate->reasonForCourse->where("degree_level", "undergraduate");
                    $graduate_level = $graduate->reasonForCourse->where("degree_level", "graduate");
                @endphp
                @if (count($undergraduate_level) > 0)
                    <div>
                        <p class="text-base-content mb-2 text-sm font-semibold">Undergraduates</p>
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

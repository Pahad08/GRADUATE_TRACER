<div>
    <div class="flex flex-col gap-3">
        @foreach ($graduate->educationalBackground as $background)
            <div class="card border-1 border-base-300 bg-base-100 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="text-neutral font-bold">Baccalaureate Degree</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <p class="text-neutral text-sm font-medium">Degree & Specialization</p>
                            <p class="text-lg font-semibold">{{ $background->degree->degree_name }}</p>
                        </div>

                        <div>
                            <p class="text-neutral text-sm font-medium">College/University</p>
                            <p class="text-lg font-semibold">{{ $background->university->university_name }}</p>
                        </div>

                        <div>
                            <p class="text-neutral text-sm font-medium">Year Graduated</p>
                            <p class="text-lg font-semibold">{{ $background->year_graduated }}</p>
                        </div>

                        <div>
                            <p class="text-neutral text-sm font-medium">Honors Received</p>
                            @php
                                $colors = ["primary", "secondary", "accent", "info", "success", "warning", "error"];
                            @endphp
                            <p>
                                @foreach ($background->honor as $honor)
                                    <span
                                        class="badge badge-outline badge-{{ $colors[array_rand($colors)] }} badge-neutral mx-1">{{ $honor->honor }}</span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3 flex flex-col gap-3">
        @foreach ($graduate->training as $training)
            <div class="card border-1 border-base-300 bg-base-100 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="text-neutral font-bold">Training/Advance Studies</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <p class="text-neutral text-sm font-medium">Title of Training</p>
                            <p class="text-lg font-semibold">{{ $training->training_name }}</p>
                        </div>

                        <div>
                            <p class="text-neutral text-sm font-medium">Duration and Credits Earned</p>
                            <p class="text-lg font-semibold">{{ $training->duration_and_credits_earned }}</p>
                        </div>

                        <div>
                            <p class="text-neutral text-sm font-medium">Name of Training Institution </p>
                            <p class="text-lg font-semibold">{{ $training->training_institution }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- <div class="">
        <h2 class="flex items-center gap-2 text-xl font-bold text-gray-800">
            <i class="fa-solid fa-user-tie text-primary"></i>
            Graduate Education
        </h2>

        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="space-y-1">
                        <p class="text-neutral text-sm font-medium">Degree</p>
                        <p class="text-lg font-semibold">Master of Science in Artificial Intelligence</p>
                    </div>

                    <div class="space-y-1">
                        <p class="text-neutral text-sm font-medium">College/University</p>
                        <p class="text-lg font-semibold">Tech Institute of Advanced Studies</p>
                    </div>

                    <div class="space-y-1">
                        <p class="text-neutral text-sm font-medium">Year Graduated</p>
                        <p class="text-lg font-semibold">2023</p>
                    </div>

                    <div class="space-y-1">
                        <p class="text-neutral text-sm font-medium">Honors Received</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="badge badge-primary">With Distinction</span>
                            <span class="badge badge-secondary">Research Excellence Award</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-neutral text-sm font-medium">Reason for Taking This Course</p>
                    <p class="text-lg">After working in the industry for several years, I wanted to deepen my knowledge
                        in AI and machine learning to advance my career in research and development of intelligent
                        systems.</p>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Examinations Section -->
    {{-- <div class="">
        <h2 class="flex items-center gap-2 text-xl font-bold text-gray-800">
            <i class="fa-solid fa-file-pen text-primary"></i>
            Professional Examinations
        </h2>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Examination</th>
                        <th>Date Taken</th>
                        <th>Rating/Score</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="font-semibold">Licensure Examination for Teachers</div>
                            <div class="text-neutral text-sm">Professional Regulation Commission</div>
                        </td>
                        <td>March 2021</td>
                        <td>
                            <div class="font-bold">92.5%</div>
                            <div class="badge badge-success gap-2">
                                <i class="fa-solid fa-check"></i>
                                Passed
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-success">Active</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-semibold">Certified Information Systems Security Professional</div>
                            <div class="text-neutral text-sm">(ISC)²</div>
                        </td>
                        <td>October 2022</td>
                        <td>
                            <div class="font-bold">780/1000</div>
                            <div class="badge badge-success gap-2">
                                <i class="fa-solid fa-check"></i>
                                Passed
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-success">Active</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-semibold">Project Management Professional</div>
                            <div class="text-neutral text-sm">Project Management Institute</div>
                        </td>
                        <td>June 2023</td>
                        <td>
                            <div class="font-bold">Above Target (4/5)</div>
                            <div class="badge badge-warning gap-2">
                                <i class="fa-solid fa-clock"></i>
                                Pending
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-warning">Processing</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-end">
            <button class="btn btn-sm btn-outline">
                <i class="fa-solid fa-plus"></i>
                Add Examination
            </button>
        </div>
    </div> --}}
</div>

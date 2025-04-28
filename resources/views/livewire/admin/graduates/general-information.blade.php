<div class="card bg-base-100 border-base-300 w-full border shadow-sm">
    <div class="card-body gap-0">
        <div>
            <h2 class="card-title text-2xl">{{ $graduate->f_name }} {{ $graduate->l_name }}</h2>
        </div>

        <div class="divider text-neutral-content text-xs"><span class="text-neutral">Personal Information</span></div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <span class="text-neutral font-bold">Sex:</span>
                <p>{{ $graduate->sex }}</p>
            </div>
            <div>
                <span class="text-neutral font-bold">Civil Status:</span>
                <p>{{ $graduate->civil_status }}</p>
            </div>
            <div>
                <span class="text-neutral font-bold">Birthday:</span>
                <p>{{ date("F j, Y", strtotime($graduate->birthdate)) }}</p>
            </div>
        </div>

        <div class="divider text-neutral-content text-xs"><span class="text-neutral">Address Information</span></div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <span class="text-neutral font-bold">Permanent Address:</span>
                <p>{{ $graduate->permanent_address }}</p>
            </div>
            <div>
                <span class="text-neutral font-bold">Location of Residence:</span>
                <p>{{ $graduate->location_of_residence }}</p>
            </div>
            <div>
                <span class="text-neutral font-bold">Region:</span>
                <p>{{ $graduate->region->region_name ?? "-" }}</p>
            </div>
            <div>
                <span class="text-neutral font-bold">Province:</span>
                <p>{{ $graduate->province->province_name ?? "-" }}</p>
            </div>
        </div>

        <div class="divider text-neutral-content text-xs"><span class="text-neutral">Contact Information</span></div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <span class="text-neutral font-bold">Email Address:</span>
                <p>{{ $graduate->email_address }}</p>
            </div>
            <div>
                <span class="text-neutral font-bold">Contact Number:</span>
                <p>{{ $graduate->contact_number }}</p>
            </div>
        </div>

    </div>
</div>

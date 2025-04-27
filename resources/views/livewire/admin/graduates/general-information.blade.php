<div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
    <div class="card bg-base-100 border-1 border-base-300 shadow-md">
        <div class="card-body p-4">
            <p class="text-neutral text-sm font-medium">First Name</p>
            <p class="text-lg font-semibold">{{ $graduate->f_name }}</p>
        </div>
    </div>

    <div class="card bg-base-100 border-1 border-base-300 shadow-md">
        <div class="card-body p-4">
            <p class="text-neutral text-sm font-medium">Last Name</p>
            <p class="text-lg font-semibold">{{ $graduate->l_name }}</p>
        </div>
    </div>

    <div class="card bg-base-100 border-1 border-base-300 shadow-md">
        <div class="card-body p-4">
            <p class="text-neutral text-sm font-medium">Permanent Address</p>
            <p class="text-lg font-semibold">{{ $graduate->permanent_address }}</p>
        </div>
    </div>

    <div class="card bg-base-100 border-1 border-base-300 shadow-md">
        <div class="card-body p-4">
            <p class="text-neutral text-sm font-medium">Email Address</p>
            <p class="text-lg font-semibold">{{ $graduate->email_address }}</p>
        </div>
    </div>

    <div class="card bg-base-100 border-1 border-base-300 shadow-md">
        <div class="card-body p-4">
            <p class="text-neutral text-sm font-medium">Contact Number</p>
            <p class="text-lg font-semibold">{{ $graduate->contact_number }}</p>
        </div>
    </div>

    <div class="card bg-base-100 border-1 border-base-300 shadow-md">
        <div class="card-body p-4">
            <p class="text-neutral text-sm font-medium">Sex</p>
            <p class="text-lg font-semibold">{{ $graduate->sex }}</p>
        </div>
    </div>

    <div class="card bg-base-100 border-1 border-base-300 shadow-md">
        <div class="card-body p-4">
            <p class="text-neutral text-sm font-medium">Civil Status</p>
            <p class="text-lg font-semibold">{{ $graduate->civil_status }}</p>
        </div>
    </div>

    <div class="card bg-base-100 border-1 border-base-300 shadow-md">
        <div class="card-body p-4">
            <p class="text-neutral text-sm font-medium">Birthday</p>
            <p class="text-lg font-semibold">
                {{ date("F j, Y", strtotime($graduate->birthdate)) }}</p>
        </div>
    </div>

    <div class="card bg-base-100 border-1 border-base-300 shadow-md">
        <div class="card-body p-4">
            <p class="text-neutral text-sm font-medium">Region</p>
            <p class="text-lg font-semibold">
                {{ $graduate->region->region_name }}</p>
        </div>
    </div>

    <div class="card bg-base-100 border-1 border-base-300 shadow-md">
        <div class="card-body p-4">
            <p class="text-neutral text-sm font-medium">Province</p>
            <p class="text-lg font-semibold">
                {{ $graduate->province->province_name }}</p>
        </div>
    </div>

    <div class="card bg-base-100 border-1 border-base-300 shadow-md">
        <div class="card-body p-4">
            <p class="text-neutral text-sm font-medium">Location of Residence</p>
            <p class="text-lg font-semibold">
                {{ $graduate->location_of_residence }}</p>
        </div>
    </div>
</div>

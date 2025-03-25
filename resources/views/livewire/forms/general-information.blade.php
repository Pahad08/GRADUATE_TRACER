<div class="rounded-none px-3" x-data="{ errors: {} }"
    x-on:general-information-error="errors = $event.detail[0]?.general_information_errors;">
    <div class="card lg:w-250 md:w-230 border-1 border-base-300 mx-auto my-5 max-w-full bg-white">
        <div class="card-body rounded-lg shadow-md">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">First
                        Name </label>
                    <input type="text" :class="errors['form.f_name'] ? 'input-error' : ''"
                        class="input w-full bg-white" wire:model="form.f_name">
                </div>
                @error("form.f_name")
                    {{ $message }}
                @enderror

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Last
                        Name </label>
                    <input type="text" :class="errors['form.l_name'] ? 'input-error' : ''"
                        class="input w-full bg-white" wire:model="form.l_name">
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Permanent
                        Address </label>
                    <input type="text" :class="errors['form.permanent_address'] ? 'input-error' : ''"
                        class="input w-full bg-white" wire:model="form.permanent_address">
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">E-mail
                        Address </label>
                    <input type="email" :class="errors['form.email_address'] ? 'input-error' : ''"
                        class="input w-full bg-white" wire:model="form.email_address">
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Contact
                        Number </label>
                    <input type="number" :class="errors['form.contact_number'] ? 'input-error' : ''"
                        class="input w-full bg-white" wire:model="form.contact_number">
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Sex
                    </label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center">
                            <input type="radio" wire:model="form.sex" :class="errors['form.sex'] ? 'radio-error' : ''"
                                class="radio" value="male">
                            <span class="ml-2">Male</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" wire:model="form.sex" :class="errors['form.sex'] ? 'radio-error' : ''"
                                class="radio" value="female">
                            <span class="ml-2">Female</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Civil
                        Status </label>
                    <select :class="errors['form.civil_status'] ? 'select-error' : ''" class="select w-full bg-white"
                        wire:model="form.civil_status">
                        <option selected>Select a civil status</option>
                        @foreach ($civil_status_selection as $key => $selection)
                            <option value="{{ $key }}">{{ ucfirst($selection) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Birthday
                    </label>
                    <input type="date" :class="errors['form.birthdate'] ? 'input-error' : ''"
                        class="input w-full bg-white" wire:model="form.birthdate">
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Region
                        of Origin </label>

                    <select :class="errors['form.region_id'] ? 'select-error' : ''" class="select w-full bg-white"
                        wire:model="form.region_id">
                        <option selected>Select a region</option>
                        @foreach ($regions as $region)
                            <option wire:key="{{ $region->region_id }}" value="{{ $region->region_id }}">
                                {{ $region->region_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Province
                    </label>
                    <select :class="errors['form.province_id'] ? 'select-error' : ''" class="select w-full bg-white"
                        wire:model="form.province_id">
                        <option selected>Select a province</option>
                        @foreach ($provinces as $province)
                            <option wire:key="{{ $province->province_id }}" value="{{ $province->province_id }}">
                                {{ $province->province_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">City
                    </label>
                    <select :class="errors['form.city'] ? 'select-error' : ''" class="select w-full bg-white"
                        wire:model="form.city">
                        <option selected>Select a city</option>
                    </select>
                </div>

                {{-- <div>
                    <label class="mb-2 block text-sm font-semibold text-neutral after:text-red-500 after:content-['*']">Location
                        of Residence </label>
                    <div class="mb-2 flex gap-4">
                        <label class="flex items-center">
                            <input type="radio" wire:model="form.location_of_residence"
                                class="radio @error("form.location_of_residence") radio-error @enderror"
                                value="City">
                            <span class="ml-2">City</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" wire:model="form.location_of_residence"
                                class="radio @error("form.location_of_residence") radio-error @enderror"
                                value="Municipality">
                            <span class="ml-2">Municipality</span>
                        </label>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>

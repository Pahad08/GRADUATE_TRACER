<div class="rounded-none px-3">
    <div class="card lg:w-250 md:w-230 border-1 border-base-300 mx-auto my-5 max-w-full bg-white">
        <div class="card-body rounded-lg shadow-md">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">First
                        Name </label>
                    <input type="text"
                        :class="{
                            'input-error': errors['tracer-components.general-information'] && errors[
                                'tracer-components.general-information']['form.f_name']
                        }"
                        class="input w-full bg-white" wire:model="form.f_name">
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Last
                        Name </label>
                    <input type="text"
                        :class="{
                            'input-error': errors['tracer-components.general-information'] && errors[
                                'tracer-components.general-information']['form.l_name']
                        }"
                        class="input w-full bg-white" wire:model="form.l_name">
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Permanent
                        Address </label>
                    <input type="text"
                        :class="{
                            'input-error': errors['tracer-components.general-information'] && errors[
                                'tracer-components.general-information']['form.permanent_address']
                        }"
                        class="input w-full bg-white" wire:model="form.permanent_address">
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">E-mail
                        Address </label>
                    <input type="email"
                        :class="{
                            'input-error': errors['tracer-components.general-information'] && errors[
                                'tracer-components.general-information']['form.email_address']
                        }"
                        class="input w-full bg-white" wire:model="form.email_address">
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Contact
                        Number </label>
                    <input type="number"
                        :class="{
                            'input-error': errors['tracer-components.general-information'] && errors[
                                'tracer-components.general-information']['form.contact_number']
                        }"
                        class="input w-full bg-white" wire:model="form.contact_number">
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Sex
                    </label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center">
                            <input type="radio" wire:model="form.sex" class="radio"
                                :class="{
                                    'radio-error': errors['tracer-components.general-information'] && errors[
                                        'tracer-components.general-information']['form.sex']
                                }"
                                value="male">
                            <span class="ml-2">Male</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" wire:model="form.sex"
                                :class="{
                                    'radio-error': errors['tracer-components.general-information'] && errors[
                                        'tracer-components.general-information']['form.sex']
                                }"
                                class="radio" value="female">
                            <span class="ml-2">Female</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Civil
                        Status </label>
                    <select
                        :class="{
                            'select-error': errors['tracer-components.general-information'] && errors[
                                'tracer-components.general-information']['form.civil_status']
                        }"
                        class="select w-full bg-white" wire:model="form.civil_status">
                        <option>Select a civil status</option>
                        @foreach ($civil_status_selection as $key => $selection)
                            <option value="{{ $selection }}" wire:key='{{ "selection-" . $key }}'>
                                {{ ucfirst($selection) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Birthday
                    </label>
                    <input type="date"
                        :class="{
                            'select-error': errors['tracer-components.general-information'] && errors[
                                'tracer-components.general-information']['form.birthdate']
                        }"
                        class="input w-full bg-white" wire:model="form.birthdate">
                </div>

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Region
                        of Origin </label>

                    <select
                        :class="{
                            'select-error': errors['tracer-components.general-information'] && errors[
                                'tracer-components.general-information']['form.region_id']
                        }"
                        class="select w-full bg-white" wire:model="form.region_id">
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
                    <select class="select w-full bg-white" wire:model="form.province_id"
                        :class="{
                            'select-error': errors['tracer-components.general-information'] && errors[
                                'tracer-components.general-information']['form.province_id']
                        }">
                        <option selected>Select a province</option>
                        @foreach ($provinces as $province)
                            <option wire:key="{{ $province->province_id }}" value="{{ $province->province_id }}">
                                {{ $province->province_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- <div class="col-span-1 md:col-span-2">
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">City
                    </label>
                    <select :class="errors['form.city'] ? 'select-error' : ''" class="select w-full bg-white"
                        wire:model="form.city">
                        <option selected>Select a city</option>
                    </select>
                </div> --}}

                <div>
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Location
                        of Residence </label>
                    <div class="mb-2 flex gap-4">
                        <label class="flex items-center">
                            <input type="radio"
                                :class="{
                                    'radio-error': errors['tracer-components.general-information'] && errors[
                                        'tracer-components.general-information']['form.location_of_residence']
                                }"
                                wire:model="form.location_of_residence" class="radio" value="city">
                            <span class="ml-2">City</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio"
                                :class="{
                                    'radio-error': errors['tracer-components.general-information'] && errors[
                                        'tracer-components.general-information']['form.location_of_residence']
                                }"
                                wire:model="form.location_of_residence" class="radio" value="municipality">
                            <span class="ml-2">Municipality</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

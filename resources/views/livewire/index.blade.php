<div id="root" x-data="listener_data">

    <livewire:components.header :childComponents="$childComponents" />

    <div class="mt-0">
        {{-- loop the components(forms) --}}
        @foreach ($childComponents as $key => $component)
            <div x-show="activeTab === '{{ $key }}'" x-transition>
                <livewire:dynamic-component :is="$key" :key="$key" />
            </div>
        @endforeach

        <input type="checkbox" id="login-modal" class="modal-toggle" />

        <div class="modal">
            <div class="modal-box">
                <div class="flex items-center gap-3">
                    <img src="{{ asset("images/logo.png") }}" alt="Company Logo" class="w-15">
                    <h2 class="text-md font-bold"><span class="uppercase">Login</span><br><span>CHED XII
                            Graduate
                            Tracer</span></h2>
                </div>

                <form class="mt-4">
                    <label class="label">
                        <span class="label-text">Username</span>
                    </label>
                    <input type="text" placeholder="Enter username" class="input mt-2 w-full" required />

                    <label class="label mt-3">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" placeholder="Enter password" class="input mt-2 w-full" required />

                    <div class="mt-4 flex justify-end gap-2">
                        <label for="login-modal" class="btn btn-soft">Cancel</label>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
            <label class="modal-backdrop" for="login-modal"></label>
        </div>
    </div>

    @script
        <script>
            Alpine.data('listener_data', () => ({
                activeTab: 'tracer-components.general-information',
                tabs: [
                    'tracer-components.general-information',
                    'tracer-components.educational-background',
                    'tracer-components.studies-information',
                    'tracer-components.employment-data',
                ],
                errors: {},
                listeners: [],

                //initialize the listeners
                init() {
                    this.listeners.push(
                        Livewire.on('general-information-error', (event) => {
                            //add the general information errors
                            if (Object.keys(event[0].general_information_errors).length > 0) {
                                this.errors['tracer-components.general-information'] = event[0]
                                    .general_information_errors;

                            } else {
                                //remove the error
                                delete this.errors['tracer-components.general-information'];
                            }

                            //set the active tab to general information tab
                            if (event[0].general_information_tab && this.activeTab ===
                                'tracer-components.employment-data') {
                                this.activeTab = event[0].general_information_tab;
                            }
                        }))

                    this.listeners.push(
                        Livewire.on('educational-background-error', (event) => {
                            //add educational background errors
                            if (Object.keys(event[0].educational_background_errors).length > 0) {
                                this.errors['tracer-components.educational-background'] = event[0]
                                    .educational_background_errors;
                            } else {
                                //remove the error
                                delete this.errors['tracer-components.educational-background'];
                            }

                            //set active tab to education background
                            if (event[0].educational_background_tab && this.activeTab !== this.tabs[0]) {
                                this.activeTab = event[0].educational_background_tab;
                            }
                        }))

                    this.listeners.push(
                        Livewire.on('studies-error', (event) => {
                            //add studies information errors
                            if (Object.keys(event[0].studies_errors).length > 0) {
                                this.errors['tracer-components.studies-information'] = event[0]
                                    .studies_errors;
                            } else {
                                //remove the error
                                delete this.errors['tracer-components.studies-information'];
                            }

                            //set active tab to studies tab
                            if (this.activeTab !== this.tabs[0] && this.activeTab !== this.tabs[1] &&
                                event[0].studies_tab) {
                                this.activeTab = event[0].studies_tab;
                            }
                        }));

                    this.listeners.push(
                        Livewire.on('employment-data-error', (event) => {
                            //add employment data errors
                            if (Object.keys(event[0].employment_data_errors).length > 0) {
                                this.errors['tracer-components.employment-data'] = event[0]
                                    .employment_data_errors;
                            } else {
                                //remove the error
                                delete this.errors['tracer-components.employment-data'];
                            }

                            const currentTab = this.activeTab;
                            this.activeTab = '';
                            this.activeTab = currentTab;
                        }));

                    //set active tab to general information if form successfully submitted
                    this.listeners.push(
                        Livewire.on('set-active-tab', (event) => {
                            this.activeTab = event[0].active_tab;
                        }));

                },
                //destroy listeners
                destroy() {
                    this.listeners.forEach((listener) => {
                        listener();
                    });
                }
            }));
        </script>
    @endscript

</div>

<div id="root" x-data="listener_data">

    <livewire:components.header :childComponents="$childComponents" />

    <div class="mt-0">
        {{-- loop the components(forms) --}}
        @foreach ($childComponents as $key => $component)
            <div x-show="activeTab === '{{ $key }}'" wire:cloak>
                <livewire:dynamic-component :is="$key" :key="$key" />
            </div>
        @endforeach
    </div>

    <div x-data="{
        message: ''
    }">
        <input x-on:graduate-created.window="message=$event.detail.message; $el.click();" type="checkbox"
            id="success-modal" class="modal-toggle" />
        <div class="modal" role="dialog">
            <div class="modal-box border-success bg-success border-l-4">
                <h3 class="text-lg font-semibold">Success!</h3>
                <p class="py-4" x-text="message"></p>
                <div class="modal-action mt-0">
                    <label class="btn btn-soft" x-on:click="activeTab = 'tracer-components.general-information'"
                        for="success-modal">Close</label>
                </div>
            </div>
        </div>
    </div>

    <div x-init="$nextTick(() => $refs.disclaimer_modal.click())">
        <input type="checkbox" id="disclaimer-modal" class="modal-toggle" x-ref="disclaimer_modal" />

        <div class="modal">
            <div class="modal-box">
                <h3 class="text-lg font-bold"><i class="fa-solid fa-circle-info"></i> Disclaimer</h3>
                <div>
                    <p class="mt-2">To proceed, you agree to the following clauses:</p>
                    <ul class="mt-3 list-inside list-disc">
                        <li class="leading-6">The data submitted is certified complete and correct by the following
                            HEI
                            President/Head/Officer-in-Charge & Registrar.
                        </li>
                        <li class="leading-6">The data will be collected through a procedure that complies with the
                            <span class="font-semibold">Republic Act No. 10173 - Data Privacy Act of 2012.</span> <a
                                class="link link-primary" target="_blank"
                                href="https://privacy.gov.ph/data-privacy-act">https://privacy.gov.ph/data-privacy-act</a>
                        </li>
                        <li class="leading-6">Data collected shall be in accordance to RA 7722, otherwise known as
                            "Higher Education Act of 1994". You can read more about here: <a class="link link-primary"
                                target="_blank" href="https://ched.gov.ph">https://ched.gov.ph</a>
                        </li>
                    </ul>
                </div>
                <div class="modal-action mt-3">
                    <label for="disclaimer-modal" class="btn btn-success">Agree</label>
                </div>
            </div>
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
                errorTabs: {},
                listeners: [],

                //initialize the listeners
                init() {
                    this.listeners.push(
                        Livewire.on('general-information-error', (event) => {
                            //set the active tab to general information tab
                            if (event[0].general_information_tab !== '' && this.activeTab ===
                                'tracer-components.employment-data') {
                                this.activeTab = event[0].general_information_tab;
                                this.errorTabs['tracer-components.general-information'] = event[0]
                                    .general_information_tab;
                            } else {
                                delete this.errorTabs['tracer-components.general-information'];
                            }
                        }))

                    this.listeners.push(
                        Livewire.on('educational-background-error', (event) => {
                            //add educational background errors
                            if (event[0].educational_background_tab !== '') {
                                this.errorTabs['tracer-components.educational-background'] = event[0]
                                    .educational_background_tab;
                                //set active tab to education background
                                if (this.activeTab !== this.tabs[0]) {
                                    this.activeTab = event[0].educational_background_tab;
                                }
                            } else {
                                //remove the error
                                delete this.errorTabs['tracer-components.educational-background'];
                            }

                        }))

                    this.listeners.push(
                        Livewire.on('studies-error', (event) => {
                            //add studies information errors
                            if (event[0].studies_tab !== '') {
                                this.errorTabs['tracer-components.studies-information'] = event[0]
                                    .studies_tab;

                                //set active tab to studies tab
                                if (this.activeTab !== this.tabs[0] && this.activeTab !== this.tabs[
                                        1] &&
                                    event[0].studies_tab) {
                                    this.activeTab = event[0].studies_tab;
                                }
                            } else {
                                //remove the error
                                delete this.errorTabs['tracer-components.studies-information'];
                            }

                        }));

                    this.listeners.push(
                        Livewire.on('employment-data-error', (event) => {
                            //add employment data errors
                            if (event[0].employment_data_tab !== '') {
                                this.errorTabs['tracer-components.employment-data'] = event[0]
                                    .employment_data_tab;
                            } else {
                                //remove the error
                                delete this.errorTabs['tracer-components.employment-data'];
                            }

                            const currentTab = this.activeTab;
                            this.activeTab = '';
                            this.activeTab = currentTab;
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

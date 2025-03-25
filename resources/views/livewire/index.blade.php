<div id="root" x-data="{ activeTab: $wire.activeTab }"
    x-on:general-information-error.window="activeTab = $event.detail[0].general_information_tab"
    x-on:educational-background-error.window="if(activeTab !== 'tracer-components.general-information'){activeTab = $event.detail[0].educational_background_tab}">
    <livewire:components.header :childComponents="$childComponents" />

    <div class="mt-0">
        @foreach ($childComponents as $key => $component)
            <div x-show="activeTab === '{{ $key }}'" x-transition>
                <livewire:dynamic-component :is="$key" :key="$key" :activeTab="$activeTab" />
            </div>
        @endforeach

        <input type="checkbox" id="login-modal" class="modal-toggle" />

        <div class="modal">
            <div class="modal-box">
                <div class="flex items-center gap-3">
                    <img src="{{ asset("images/logo.png") }}" alt="Company Logo" class="w-15">
                    <h2 class="text-md font-bold"><span class="uppercase">Login</span><br><span>CHED XII Graduate
                            Tracer</span></h2>
                </div>

                <form class="mt-4">
                    <label class="label">
                        <span class="label-text">Username</span>
                    </label>
                    <input type="text" placeholder="Enter username" class="input input-bordered w-full" required />

                    <label class="label mt-3">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" placeholder="Enter password" class="input input-bordered w-full" required />

                    <div class="mt-4 flex justify-end gap-2">
                        <label for="login-modal" class="btn btn-soft">Cancel</label>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
            <label class="modal-backdrop" for="login-modal"></label>
        </div>
    </div>

</div>

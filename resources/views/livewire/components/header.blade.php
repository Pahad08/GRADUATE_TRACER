<div class="shadow-screen z-99 sticky top-0 w-full p-0">
    <div class="bg-primary flex w-full items-center gap-4 p-3">
        <a href="/" wire:navigate>
            @persist("logo")
                <img src="{{ asset("images/logo.png") }}" alt="CHED logo" class="w-13">
            @endpersist
        </a>
        <div>
            <span class="text-base-100 hidden text-sm font-semibold md:inline">COMMISSION ON HIGHER EDUCATION REGIONAL
                OFFICE
                XII</span><br class="hidden md:inline">
            <span class="text-base-100 text-sm font-semibold">CHED XII Graduate Tracer</span>
        </div>
    </div>

    <div class="tabs bg-neutral-content items-start justify-between">
        <div class="hidden md:block">
            {{-- loop the tabs --}}
            @foreach ($childComponents as $key => $component)
                <a role="tab" class="tab font-semibold"
                    :class="{
                        'tab-active': activeTab === '{{ $key }}',
                        'text-error! hover:text-error': errorTabs.hasOwnProperty('{{ $key }}')
                    }"
                    x-on:click="activeTab = '{{ $key }}'"><i
                        class="fa-solid {{ $component["icon"] }}"></i>&nbsp{{ $component["title"] }}</a>
            @endforeach
        </div>

        <div class="tab dropdown dropdown-right px-0 font-semibold md:hidden">
            <div tabindex="0" class="tab"><i class="fa-solid fa-caret-down mr-2"></i> Sections</div>
            <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-75 p-2 shadow-sm">
                @foreach ($childComponents as $key => $component)
                    <a role="tab" class="tab justify-start font-semibold"
                        :class="{
                            'tab-active': activeTab === '{{ $key }}',
                            'text-error! hover:text-error': errorTabs.hasOwnProperty('{{ $key }}'),
                        
                        }"
                        x-on:click="activeTab = '{{ $key }}'"><i
                            class="fa-solid {{ $component["icon"] }}"></i>&nbsp{{ $component["title"] }}</a>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="bg-error hidden w-full justify-center text-center" wire:offline.class="flex"
        wire:offline.class.remove="hidden">
        <span class="text-md italic text-white">No Internet Connection</span>
    </div>
</div>

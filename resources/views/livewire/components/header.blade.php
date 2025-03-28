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
        <div>
            {{-- loop the tabs --}}
            @foreach ($childComponents as $key => $component)
                <a role="tab" class="tab font-semibold"
                    :class="{
                        'tab-active': activeTab === '{{ $key }}',
                        'text-error! hover:text-error': errors.hasOwnProperty('{{ $key }}')
                    }"
                    x-on:click="activeTab = '{{ $key }}'"><i
                        class="fa-solid {{ $component["icon"] }}"></i>&nbsp{{ $component["title"] }}</a>
            @endforeach
        </div>

        <label class="tab font-semibold" for="login-modal">
            <a for="login-modal"><i class="fa-solid fa-right-to-bracket"></i>&nbsp;Login</i>
            </a>
        </label>
    </div>
</div>

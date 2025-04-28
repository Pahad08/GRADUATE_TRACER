<div class="shadow-screen z-99 sticky top-0 w-full p-0">
    <div class="bg-primary flex w-full items-center gap-4 p-3">
        <a href="/" wire:navigate>
            <img src="{{ asset("images/logo.png") }}" alt="CHED logo" class="w-13">
        </a>
        <div>
            <span class="text-base-100 hidden text-sm font-semibold md:inline">COMMISSION ON HIGHER EDUCATION REGIONAL
                OFFICE XII</span><br class="hidden md:inline">
            <span class="text-base-100 text-sm font-semibold">CHED XII Graduate Tracer</span>
        </div>
    </div>

    <div class="tabs bg-neutral-content items-start justify-between">
        <div class="hidden md:block">
            {{-- loop the links --}}
            @foreach ($links as $key => $link)
                <a href="{{ $link["url"] }}" ... wire:current="tab-active" class="tab font-semibold" wire:navigate>
                    <i class="fa-solid {{ $link["icon"] }}">
                    </i>&nbsp{{ $link["title"] }}</a>
            @endforeach
        </div>

        <label class="tab hidden font-semibold md:inline-flex" for="logout_modal">
            <span><i class="fa-solid fa-right-to-bracket"></i>&nbsp;Logout</span>
        </label>

        <div class="tab dropdown dropdown-right px-0 font-semibold md:hidden">
            <div tabindex="0" class="tab"><i class="fa-solid fa-caret-down mr-2"></i> Menu</div>
            <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                @foreach ($links as $key => $link)
                    <a href="{{ $link["url"] }}" ... wire:current="tab-active" class="tab justify-start font-semibold"
                        wire:navigate>
                        <i class="fa-solid {{ $link["icon"] }}">
                        </i>&nbsp{{ $link["title"] }}</a>
                @endforeach
            </ul>
        </div>
    </div>

    <input type="checkbox" id="logout_modal" class="modal-toggle" />

    <div class="modal" role="dialog">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Logout</h3>
            <p class="py-4">Are you sure you want to logout?
            </p>
            <div class="modal-action mt-0">
                <label wire:loading.attr="disabled" for="logout_modal" class="btn btn-error">Close</label>
                <label class="btn btn-success" wire:loading.attr="disabled"
                    wire:click="logout"><span>Logout</span></label>
            </div>
        </div>
    </div>

</div>

<div class="shadow-screen z-99 sticky top-0 w-full p-0">
    <div class="bg-primary flex w-full items-center gap-4 p-3">
        <a href="/admin" wire:navigate>
            <img src="{{ asset("images/logo.png") }}" alt="CHED logo" class="w-13">
        </a>
        <div>
            <span class="text-primary-content hidden text-sm font-semibold sm:inline">COMMISSION ON HIGHER EDUCATION
                REGIONAL OFFICE-XII</span><br class="hidden sm:inline">
            <span class="text-primary-content text-sm font-semibold">Graduate Tracer System</span>
        </div>
    </div>

    <div class="tabs bg-base-300 items-start justify-between" x-data="{ isLogoutModalOpen: false, isProfileModalOpen: false }">
        {{-- loop the links --}}
        <div class="hidden lg:block">
            {{-- loop the links --}}
            @foreach ($links as $key => $link)
                <a wire:key='{{ $key }}' href="{{ $link["url"] }}" ... wire:current="tab-active"
                    class="tab font-semibold" wire:navigate>
                    <i class="fa-solid {{ $link["icon"] }}">
                    </i>&nbsp{{ $link["title"] }}</a>
            @endforeach
        </div>

        <div class="tab dropdown dropdown-end hidden px-0 font-semibold lg:block">
            <div tabindex="0" class="tab"><i class="fa-solid fa-caret-down mr-2"></i> Profile</div>
            <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                <li>
                    <p x-on:click="isProfileModalOpen = true"><i class="fa-solid fa-user"></i> Profile</p>
                </li>
                <li>
                    <p x-on:click="isLogoutModalOpen = true"><i class="fa-solid fa-right-from-bracket"></i> Logout</p>
                </li>
            </ul>
        </div>

        <div class="tab dropdown dropdown-right px-0 font-semibold lg:hidden">
            <div tabindex="0" class="tab"><i class="fa-solid fa-caret-down mr-2"></i> Menu</div>
            <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-60 p-2 shadow-sm">
                @foreach ($links as $key => $link)
                    <li>
                        <a href="{{ $link["url"] }}" ... wire:current="tab-active" wire:key='{{ $key }}'
                            class="tab justify-start font-semibold" wire:navigate>
                            <i class="fa-solid {{ $link["icon"] }}">
                            </i>&nbsp{{ $link["title"] }}</a>
                    </li>
                @endforeach
                <li>
                    <p x-on:click="isProfileModalOpen = true" class="tab justify-start font-semibold"><i
                            class="fa-solid fa-user"></i> Profile</p>
                </li>
                <li>
                    <p x-on:click="isLogoutModalOpen = true" class="tab justify-start font-semibold"><i
                            class="fa-solid fa-right-from-bracket"></i> Logout</p>
                </li>
            </ul>
        </div>

        <div class="modal" :class="{ 'modal-open': isLogoutModalOpen }" role="dialog">
            <div class="modal-box">
                <h3 class="text-lg font-bold">Logout</h3>
                <p class="py-4">Are you sure you want to logout?</p>
                <div class="modal-action mt-0">
                    <button wire:loading.attr="disabled" x-on:click="isLogoutModalOpen = false"
                        class="btn btn-sm btn-soft">Close</button>
                    <label class="btn btn-sm btn-success" wire:loading.attr="disabled"
                        wire:click="logout"><span>Logout</span></label>
                </div>
            </div>
        </div>

        <div class="modal" :class="{ 'modal-open': isProfileModalOpen }" role="dialog">
            <form class="modal-box" wire:submit='editProfile'>
                <h3 class="text-lg font-bold">Profile</h3>
                <div x-data="{ message: '', show: false, timeout: null }"
                    x-on:profile-updated.window="message = event.detail; if (timeout) {clearTimeout(timeout)} 
                    show = true; timeout= setTimeout(() => show = false, 2000);">
                    <template x-if="show">
                        <div class="alert alert-success my-2">
                            <i class="fa-solid fa-check"></i>
                            <span x-text="message"></span>
                        </div>
                    </template>
                </div>

                <div class="mt-3">
                    <div class="relative w-full">
                        <label class="label after:text-error text-sm font-semibold after:content-['*']">Username</label>
                        <input @class(["input w-full", "input-error" => $errors->has("username")]) type="text" wire:model='username'>

                        @error("username")
                            <p class="text-error mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative mt-3 w-full">
                        <label class="label text-sm font-semibold">Password</label>
                        <input @class(["input w-full", "input-error" => $errors->has("password")]) type="password" wire:model='password'>

                        @error("password")
                            <p class="text-error mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="modal-action mt-3">
                    <button wire:loading.attr="disabled" type="button" x-on:click="isProfileModalOpen = false"
                        class="btn btn-sm btn-soft">Close</button>
                    <button class="btn btn-sm btn-success" wire:loading.attr="disabled"><span>Submit</span></button>
                </div>
            </form>
        </div>
    </div>

    <input type="checkbox" id="my_modal_6" class="modal-toggle" />
    <div class="modal" role="dialog">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Hello!</h3>
            <p class="py-4">This modal works with a hidden checkbox!</p>
            <div class="modal-action">
                <label for="my_modal_6" class="btn">Close!</label>
            </div>
        </div>
    </div>

</div>

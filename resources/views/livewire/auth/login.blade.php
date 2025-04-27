<div class="flex min-h-screen items-center justify-center">
    <div class="card w-full max-w-md bg-white p-6 shadow-md">
        <div class="mb-4 flex items-center gap-3">
            <img src="{{ asset("images/logo.png") }}" alt="Company Logo" class="w-15">
            <h2 class="text-md font-bold">
                <span class="uppercase">Login</span><br>
                <span>CHED XII Graduate Tracer</span>
            </h2>
        </div>

        <form wire:submit='login'>
            <div>
                <label class="label font-semibold" for="username">Username</label>
                <input type="text" id="username" placeholder="Enter username" class="input mt-2 w-full"
                    wire:model='username' />
                @error("username")
                    <p class="text-error mt-1 text-sm">{{ $message }} </p>
                @enderror
            </div>

            <div x-data="{ show: false }" x-on:show.window="show = !show;">
                <label class="label mt-3 font-semibold" for="password">Password</label>
                <input :type="!show ? 'password' : 'text'" id="password" placeholder="Enter password"
                    class="input mt-2 w-full" wire:model='password' />
                @error("password")
                    <p class="text-error mt-1 text-sm">{{ $message }}</p>
                @enderror
                @error("invalid_credentials")
                    <p class="text-error mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-2" x-data="{ show: false }">
                <input x-on:click="$dispatch('show')" type="checkbox" id="show-password"
                    class="toggle toggle-sm checked:border-success checked:text-success" />
                <label for="show-password" class="label text-sm">Show Password</label>
            </div>

            <div class="mt-3 flex justify-end gap-2">
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Login <i
                        class="fa-solid fa-right-to-bracket"></i></button>
            </div>
        </form>
    </div>
</div>

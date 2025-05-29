<div class="flex min-h-screen items-center justify-center px-4">
    <div class="card bg-base-200 border-base-300 w-full max-w-md border shadow-md">
        <div class="card-body">
            <div class="mb-4 flex items-center gap-4">
                <img src="{{ asset("images/logo.png") }}" alt="Company Logo" class="h-16 w-16 object-contain" />
                <div>
                    <h2 class="text-xl font-bold uppercase">Login</h2>
                    <p class="text-base-content/70 text-sm">CHED XII Graduate Tracer</p>
                </div>
            </div>

            <form wire:submit='login' class="space-y-4">
                <div>
                    <label for="username" class="label mb-1">
                        <span class="label-text font-medium">Username</span>
                    </label>
                    <input id="username" type="text" placeholder="Enter username"
                        class="input input-bordered w-full" wire:model='username' />
                    @error("username")
                        <p class="text-error mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="label mb-1">
                        <span class="label-text font-medium">Password</span>
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" id="password" placeholder="Enter password"
                            class="input input-bordered w-full pr-10" wire:model='password' />
                        <button type="button"
                            class="text-neutral absolute inset-y-0 right-2 flex cursor-pointer items-center"
                            @click="show = !show">
                            <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                        </button>
                    </div>
                    @error("password")
                        <p class="text-error mt-1 text-sm">{{ $message }}</p>
                    @enderror
                    @error("invalid_credentials")
                        <p class="text-error mt-1 text-sm">{{ $message }}</p>
                    @enderror
                    @error("too_many_attempts")
                        <p class="text-error mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-control mt-4">
                    <button type="submit" class="btn btn-primary w-full">
                        <i class="fa-solid fa-right-to-bracket mr-2"></i> Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

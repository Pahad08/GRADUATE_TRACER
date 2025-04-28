<div id="root">

    <livewire:components.admin.header />

    <div class="mt-0" x-data="{ active: 'admin.graduates.employment-data' }">
        <div class="rounded-lg px-3">
            <div class="md:w-300 mx-auto my-5 w-full max-w-full rounded">
                <div class="flex flex-col justify-between gap-y-3 md:flex-row md:items-center">
                    <div class="breadcrumbs text-sm">
                        <ul>
                            <li>
                                <a wire:navigate href="{{ route("dashboard") }}">
                                    <i class="fa-solid fa-chart-simple"></i>
                                    Analytics
                                </a>
                            </li>
                            <li>
                                <a wire:navigate href="/graduates">
                                    <i class="fa-solid fa-user-graduate"></i>
                                    Graduates
                                </a>
                            </li>
                            <li>
                                <span class="inline-flex items-center gap-2">
                                    <i class="fa-solid fa-clipboard-list"></i>
                                    Details
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="bg-secondary mt-2 w-full overflow-x-auto whitespace-nowrap rounded-t px-3 py-2">
                    <div>
                        @foreach ($sections as $key => $section)
                            <a role="tab" class="tab font-semibold"
                                :class="{
                                    'text-base-100!': active == '{{ $key }}',
                                }"
                                x-on:click="active = '{{ $key }}'" wire:key='{{ $key }}'><i
                                    class="fa-solid {{ $section["icon"] }}"></i>&nbsp;{{ $section["title"] }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-b bg-white p-6 shadow-md">
                    @foreach ($sections as $key => $sec)
                        <div class="card" wire:cloak x-show="active === '{{ $key }}'"
                            wire:key='{{ $key }}'>
                            <livewire:dynamic-component :is="$key" :key="$key" :graduate="$graduate" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>

<div id="root">

    <livewire:components.hei.header />

    <div class="mt-0" x-data="{ active: 'admin.graduates.general-information' }">
        <div class="rounded-lg px-3">
            <div class="md:w-300 mx-auto my-5 w-full max-w-full rounded">
                <div class="flex flex-col justify-between gap-y-3 md:flex-row md:items-center">
                    <div class="breadcrumbs text-sm">
                        <ul>
                            <li>
                                <a wire:navigate href="/home}">
                                    <i class="fa-solid fa-chart-simple"></i>
                                    Analytics
                                </a>
                            </li>
                            <li>
                                <a wire:navigate href="/view_graduates">
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

                <livewire:components.view_graduate :sections="$sections" :graduate="$graduate" />
            </div>
        </div>
    </div>

</div>

<div>
    <div class="bg-base-300 mt-2 w-full overflow-x-auto whitespace-nowrap rounded-t px-3 py-2">
        <div>
            @foreach ($sections as $key => $section)
                <a role="tab" class="tab font-semibold"
                    :class="{
                        'text-base-content!': active == '{{ $key }}',
                    }"
                    x-on:click="active = '{{ $key }}'" wire:key='{{ $key }}'><i
                        class="fa-solid {{ $section["icon"] }}"></i>&nbsp;{{ $section["title"] }}</a>
            @endforeach
        </div>
    </div>

    <div class="bg-base-100 border-base-300 rounded-b border p-0 shadow-md">
        @foreach ($sections as $key => $sec)
            <div class="card" wire:cloak x-show="active === '{{ $key }}'" wire:key='{{ $key }}'>
                <livewire:dynamic-component :is="$key" :key="$key" :graduate="$graduate" />
            </div>
        @endforeach
    </div>
</div>

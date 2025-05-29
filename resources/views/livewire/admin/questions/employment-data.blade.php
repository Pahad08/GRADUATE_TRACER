<div class="grid grid-cols-2 gap-4 md:grid-cols-2 lg:grid-cols-3" wire:sortable="updateOrder"
    wire:sortable.options="{ animation: 100 }">
    @foreach ($labels as $key => $label)
        <div class="card bg-base-100 border-1 border-base-300 shadow-sm"
            @if ($label["is_visible"]) wire:sortable.item="{{ $key }}" @endif
            wire:key="question-{{ $label["question_order"] }}">
            <div class="absolute right-3 top-3 flex items-center space-x-2">
                <span class="cursor-pointer" wire:sortable.handle>
                    <i class="fa-solid fa-grip-vertical"></i>
                </span>
                @if ($label["custom_question"])
                    <label wire:click='$dispatch("set-question-to-remove","{{ $key }}")' for="remove-question"
                        class="text-error cursor-pointer hover:text-rose-800">
                        <i class="fa-solid fa-trash"></i>
                    </label>
                @endif
            </div>

            <div class="card-body">
                <h6 class="text-md font-semibold">{{ $label["label"] }}</h6>

                <div class="mt-2 flex items-center gap-5">
                    <span class="text-secondary font-semibold">Visibility:</span>
                    <input type="checkbox" @checked($label["is_visible"])
                        wire:click='setLabelVisibility("{{ $key }}")'
                        class="toggle border-error text-error checked:border-success checked:text-success" />
                </div>
            </div>
        </div>
    @endforeach
</div>

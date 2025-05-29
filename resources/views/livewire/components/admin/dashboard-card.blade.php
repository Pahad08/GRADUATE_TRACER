<div class="card border-base-300 border bg-white p-4 shadow-sm">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold">{{ $title }}</h2>
        <i class="fa-solid {{ $icon }} text-lg"></i>
    </div>

    <p class="{{ "text-" . $color }} text-4xl font-bold">{{ $total }}</p>
</div>

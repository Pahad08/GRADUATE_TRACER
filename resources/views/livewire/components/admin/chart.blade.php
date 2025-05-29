<div>
    <div wire:ignore class="card border-base-300 border bg-white p-4 shadow">
        <h2 class="mb-2 font-semibold">{{ $title }}</h2>
        <div id="{{ $id }}"></div>
    </div>

    @script
        <script>
            const chartApex = new ApexCharts($wire.$el.querySelector("#{{ $id }}"),
                {{ Illuminate\Support\Js::from($options) }});
            chartApex.render();

            Livewire.on('year-changed', (data) => {
                if (data['{{ $data_to_fetch }}']) {
                    chartApex.updateOptions(data['{{ $data_to_fetch }}']['options'], true);
                    chartApex.updateSeries(data['{{ $data_to_fetch }}']['series'], true);
                }
            });
        </script>
    @endscript
</div>

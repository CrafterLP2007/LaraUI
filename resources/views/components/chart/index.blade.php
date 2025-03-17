@props([
    'uuid' => 'lara-ui-chart' . \Illuminate\Support\Str::random(8),
])

@checkPluginInstalled('Chart')

<div
    wire:key="{{ $uuid }}"
    x-data="{
            chart: null,
            settings: @entangle($attributes->wire('model')),
            init() {
                this.chart = new window.ApexCharts(this.$el, this.settings);
                this.chart.render();
            }
        }"
>
    <div x-ref="chart"></div>
</div>

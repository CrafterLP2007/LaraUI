@props([
    'id' => 'offcanvas-' . \Illuminate\Support\Str::random(8)
])

<div
    x-data="{
        id: '{{ $id }}',
        open: false,
        toggle() { this.open = !this.open },
        close() { this.open = false }
    }"
    @open-offcanvas.window="if ($event.detail.id === id) open = true"
    @close-offcanvas.window="if ($event.detail.id === id) open = false"
    @toggle-offcanvas.window="if ($event.detail.id === id) toggle()"
    {{ $attributes }}
>
    {{ $slot }}
</div>

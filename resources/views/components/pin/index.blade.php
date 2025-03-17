@props([
    'variant' => 'default',
    'placeholder' => '⚬',
    'length' => 4,
    'type' => 'text',
    'size' => 'default'
])

@php
    if (!$length > 1) {
        throw new Exception('Length must be greater than 1');
    }
@endphp

@inject('pinService', 'CrafterLP2007\LaraUi\Services\LaraUI\PinCvaService')

<div
    data-hs-pin-input=""
    class="flex gap-x-3"
>
    @foreach(range(1, $length) as $index)
        <input
            type="{{ $type }}"
            {{ $attributes->twMerge($pinService::new()(['variant' => $variant, 'size' => $size])) }}
            placeholder="{{ $placeholder }}"
            data-hs-pin-input-item=""
            maxlength="1">
    @endforeach
</div>

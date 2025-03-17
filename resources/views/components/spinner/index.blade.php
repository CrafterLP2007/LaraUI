@props([
    'uuid' => 'lara-ui-spinner-' . Str::random(8),
    'color' => 'primary',
    'size' => 'default',
    'loading' => null
])

@inject('spinnerService', 'CrafterLP2007\LaraUi\Services\LaraUI\SpinnerCvaService')

<div
    {{ $attributes->twMerge($spinnerService::new()(['variant' => $color, 'size' => $size])) }}
    {{ $attributes }}
    @if($loading)
        wire:loading
    wire:target="{{ $loading }}"
    @endif
    role="status"
    aria-label="loading"
>
</div>

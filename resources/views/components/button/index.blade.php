@props([
    'variant' => 'solid',
    'color' => 'primary',
    'loading' => null,
    'ignoreLoadingText' => false,
    'link' => null,
])

@php
    if (!function_exists('loadingTarget')) {
        function loadingTarget($attributes, $loading): ?string
        {
            if ($loading == 1) {
                return $attributes->whereStartsWith('wire:click')->first();
            }

            return $loading;
        }
    }
@endphp

@inject('buttonService', 'CrafterLP2007\LaraUi\Services\LaraUI\ButtonCvaService')

@if($link)
    <a
        href="{{ $link }}"
        {{ $attributes->twMerge($buttonService::new()([$variant => $color])) }}>
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->twMerge($buttonService::new()([$variant => $color])) }}
            @if(!$attributes->whereStartsWith('type')->first())
                type="button"
            @endif
            @if($loading)
                wire:target="{{ loadingTarget($attributes, $loading) }}"
            wire:loading.attr="disabled"
            @endif
        >
        @if($loading)
            <span wire:loading wire:target="{{ loadingTarget($attributes, $loading) }}" class="animate-spin inline-block size-4 border-3 border-current border-t-transparent text-white rounded-full" role="status" aria-label="loading"></span>
        @endif

            @if($ignoreLoadingText)
                <span wire:loading.remove wire:target="{{ loadingTarget($attributes, $loading) }}">
                {{ $slot }}
            </span>
            @else
                {{ $slot }}
            @endif
    </button>
@endif

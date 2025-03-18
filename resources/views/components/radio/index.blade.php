@props([
    'showValidation' => true,
])

<div x-data="{
    uuid: Math.random().toString(20).substring(2, 20),
    selected: @if($attributes->whereStartsWith('wire:model')->first()) @entangle($attributes->wire('model')) @else null @endif,
}">
    {{ $slot }}

    @if($attributes->whereStartsWith('wire:model')->first() && $errors->has($attributes->whereStartsWith('wire:model')->first()) && $showValidation)
        <div class="mt-2 text-sm text-red-600">{{ $errors->first($attributes->whereStartsWith('wire:model')->first()) }}</div>
    @endif
</div>

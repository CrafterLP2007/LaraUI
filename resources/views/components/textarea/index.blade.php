@props([
    'variant' => 'default',
    'floating' => false,
    'label' => null,
    'hint' => null,
    'cornerHint' => null,
    'showValidation' => true,
])

@inject('textareaService', 'CrafterLP2007\LaraUi\Services\LaraUI\TextareaCvaService')

<div class="relative" x-data="{ uuid: Math.random().toString(20).substring(2, 20) }">
    @if($label && !$floating)
        <div class="flex justify-between items-center mb-2">
            <label x-bind:for="uuid" class="block text-sm font-medium dark:text-white">
                {{ $label }}
            </label>
            @if($cornerHint)
                <span class="text-sm text-gray-500 dark:text-neutral-400">{{ $cornerHint }}</span>
            @endif
        </div>
    @endif

    <textarea
        x-bind:id="uuid"
        {{ $attributes }}
        @if($floating)
            {{ $attributes->twMerge(
                $textareaService::new()(['floating' => ($attributes->whereStartsWith('wire:model')->first() &&
                $errors->has($attributes->whereStartsWith('wire:model')->first()) &&
                $showValidation) ? 'error' : $variant])
            ) }}
            placeholder=" "
    @else
        {{ $attributes->twMerge(
            $textareaService::new()(['default' => ($attributes->whereStartsWith('wire:model')->first() &&
            $errors->has($attributes->whereStartsWith('wire:model')->first()) &&
            $showValidation) ? 'error' : $variant])
        ) }}
        @endif
    ></textarea>

    @if($floating)
        <label
            x-bind:id="uuid"
            class="absolute top-0 start-0 p-4 h-full sm:text-sm truncate pointer-events-none transition ease-in-out duration-100 origin-[0_0] dark:text-white peer-disabled:opacity-50 peer-disabled:pointer-events-none
            peer-focus:scale-90
            peer-focus:translate-x-0.5
            peer-focus:-translate-y-1.5
            peer-focus:text-gray-500 dark:peer-focus:text-neutral-500
            peer-not-placeholder-shown:scale-90
            peer-not-placeholder-shown:translate-x-0.5
            peer-not-placeholder-shown:-translate-y-1.5
            peer-not-placeholder-shown:text-gray-500 dark:peer-not-placeholder-shown:text-neutral-500 dark:text-neutral-500"
        >
            {{ $label }}
        </label>
    @endif

    @if($hint)
        <p class="mt-2 text-sm text-gray-500 dark:text-neutral-400">{{ $hint }}</p>
    @endif

    @if($attributes->whereStartsWith('wire:model')->first() && $errors->has($attributes->whereStartsWith('wire:model')->first()) && $showValidation)
        <div
            class="text-red-600 text-sm">{{ $errors->first($attributes->whereStartsWith('wire:model')->first()) }}</div>
    @endif
</div>


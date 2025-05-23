@props([
    'labelRight' => null,
    'labelLeft' => null,
    'hint' => null,
    'withIcons' => false,
    'showValidation' => true
])

<div class="flex items-center gap-x-3" x-data="{ uuid: Math.random().toString(20).substring(2, 20) }">
    @if($labelLeft)
        <label x-bind:for="uuid"
               class="text-sm text-gray-500 dark:text-neutral-400">{{ $labelLeft }}</label>
    @endif
    <label x-bind:for="uuid" class="relative inline-block w-11 h-6 cursor-pointer">
        <input type="checkbox" x-bind:id="uuid" class="peer sr-only" {{ $attributes }}>
        <span
            class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
        <span
            class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>

        @if($withIcons)
            <span
                class="absolute top-1/2 start-0.5 -translate-y-1/2 flex justify-center items-center size-5 text-gray-500 peer-checked:text-white transition-colors duration-200 dark:text-neutral-500">
                  <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                       fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                  </svg>
            </span>
            <!-- Right Icon (On) -->
            <span
                class="absolute top-1/2 end-0.5 -translate-y-1/2 flex justify-center items-center size-5 text-gray-500 peer-checked:text-blue-600 transition-colors duration-200 dark:text-neutral-500">
              <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                   fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
              </svg>
            </span>
        @endif
    </label>
    @if($labelRight)
        <label x-bind:for="uuid"
               class="text-sm text-gray-500 dark:text-neutral-400">{{ $labelRight }}</label>
    @endif
</div>

@if($hint)
    <p class="mt-2 text-sm text-gray-500 dark:text-neutral-500">{{ $hint }}</p>
@endif

@if($attributes->whereStartsWith('wire:model')->first() && $errors->has($attributes->whereStartsWith('wire:model')->first()) && $showValidation)
    <div class="text-red-600 text-sm">{{ $errors->first($attributes->whereStartsWith('wire:model')->first()) }}</div>
@endif

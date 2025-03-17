@props([
    'uuid' => 'lara-ui-datepicker-' . Str::random(8),
    'label' => null,
    'cornerHint' => null,
    'hint' => null,
    'maxDate' => now()->addYears(10),
    'placeholder' => null,
    'showValidation' => true,
    'mode' => 'custom-select'
])

<div class="relative" x-data="{ uuid: Math.random().toString(20).substring(2, 20) }">
    @if($label)
        <div class="flex justify-between items-center mb-2">
            <label x-bind:for="uuid" class="block text-sm font-medium dark:text-white">
                {{ $label }}
            </label>
            @if($cornerHint)
                <span class="text-sm text-gray-500 dark:text-neutral-400">{{ $cornerHint }}</span>
            @endif
        </div>
    @endif

    <input
        class="hs-datepicker py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-600 focus:ring-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder:text-neutral-400 dark:focus:border-blue-500 dark:focus:ring-neutral-500"
        type="text" placeholder="{{ $placeholder }}" data-hs-datepicker='{
    "type": "default",
    "dateMax": "{{ $maxDate }}",
    "mode": "{{ $mode }}",
    "templates": {
      "arrowPrev": "<button data-vc-arrow=\"prev\"><svg class=\"shrink-0 size-4\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m15 18-6-6 6-6\"></path></svg></button>",
      "arrowNext": "<button data-vc-arrow=\"next\"><svg class=\"shrink-0 size-4\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m9 18 6-6-6-6\"></path></svg></button>"
    }
  }'>

    @if($hint)
        <p class="mt-2 text-sm text-gray-500 dark:text-neutral-400">{{ $hint }}</p>
    @endif

    @if($attributes->whereStartsWith('wire:model')->first() && $errors->has($attributes->whereStartsWith('wire:model')->first()) && $showValidation)
        <div
            class="text-red-600 text-sm">{{ $errors->first($attributes->whereStartsWith('wire:model')->first()) }}</div>
    @endif
</div>

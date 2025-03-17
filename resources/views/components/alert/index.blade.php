@props([
    'variant' => 'solid',
    'color' => 'dark',
    'dismissible' => false,
])

@inject('alertService', 'CrafterLP2007\LaraUi\Services\LaraUI\AlertCvaService')

<div {{ $attributes->twMerge($alertService::new()([$variant => $color])) }} role="alert" tabindex="-1" aria-labelledby="hs-solid-color-dark-label">
    <div class="flex w-full items-center justify-between">
        {{ $slot }}

        @if($dismissible)
            <button type="button" class="inline-flex bg-teal-50 rounded-lg p-1.5 text-teal-500 hover:bg-teal-100 focus:outline-hidden focus:bg-teal-100 dark:bg-transparent dark:text-teal-600 dark:hover:bg-teal-800/50 dark:focus:bg-teal-800/50 ml-3 shrink-0" data-hs-remove-element="#dismiss-alert">
                <span class="sr-only">Dismiss</span>
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        @endif
    </div>
</div>

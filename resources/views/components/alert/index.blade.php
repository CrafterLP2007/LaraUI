@props([
    'variant' => 'solid',
    'color' => 'primary',
])

@inject('alertService', 'CrafterLP2007\LaraUi\Services\LaraUI\AlertCvaService')

<div {{ $attributes->twMerge($alertService::new()([$variant => $color])) }} role="alert" tabindex="-1" aria-labelledby="hs-solid-color-dark-label">
    <div class="flex w-full items-center">
        {{ $slot }}
    </div>
</div>

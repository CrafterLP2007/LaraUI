@props([
    'variant' => 'solid',
    'color' => 'primary',
])

@inject('badgeService', 'CrafterLP2007\LaraUi\Services\LaraUI\BadgeCvaService')

<span {{ $attributes->twMerge($badgeService::new()([$variant => $color])) }}>
    {{ $slot }}
</span>

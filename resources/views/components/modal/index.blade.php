@props([
    'id' => 'lara-ui-modal-' . Str::random(8),
    'position' => 'centered',
    'size' => 'small',
    'animation' => 'scale',
    'backgroundClasses' => '',
    'alwaysOpen' => false,
])

@inject('modalService', 'CrafterLP2007\LaraUi\Services\LaraUI\ModalCvaService')

<div
    id="{{ $id }}"
    {{ $attributes->merge(['class' => 'hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all ' . $backgroundClasses]) }}
    role="dialog"
    tabindex="-1"
    aria-labelledby="{{ $id }}-label"
>
    <div
        {{ $attributes->twMerge($modalService::new()(['position' => $position, 'animation' => $animation, 'size' => $size])) }}>
        <div class="w-full flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
            {{ $slot }}
        </div>
    </div>
</div>

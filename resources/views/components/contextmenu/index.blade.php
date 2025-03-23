<div
    x-data="{
        open: false,
        position: { x: 0, y: 0 }
    }"
    @click.away="open = false"
    @keydown.escape.window="open = false"
    class="relative z-20"
>
    {{ $slot }}

    <div
        x-show="open"
        :style="{
            position: open ? 'fixed' : '',
            left: open ? position.x + 'px' : '',
            top: open ? position.y + 'px' : ''
        }"
        {{ $attributes->twMerge('min-w-60 bg-white shadow-md rounded-lg dark:bg-neutral-800 dark:border dark:border-neutral-700') }}
        role="menu"
    >
        {{ $items }}
    </div>
</div>

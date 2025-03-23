<div
    {{ $attributes->twMerge('cursor-context-menu') }}
    @contextmenu.prevent="
        open = true;
        position = {
            x: $event.clientX,
            y: $event.clientY
        };
    "
    @click="open = false"
>
    {{ $slot }}
</div>

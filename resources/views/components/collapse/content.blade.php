<div x-show="isOpen"
     {{ $attributes->twMerge('w-full overflow-hidden') }} x-collapse>
    {{ $slot }}
</div>

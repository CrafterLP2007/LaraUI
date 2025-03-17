<div class="hs-accordion-group" x-data="{ uuid: Math.random().toString(20).substring(2, 20), selectedAccordionItem: '' }">
    <div {{ $attributes->twMerge('hs-accordion active') }} x-bind:id="uuid">
        {{ $slot }}
    </div>
</div>

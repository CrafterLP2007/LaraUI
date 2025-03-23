/* Listeners for livewire */
document.addEventListener('livewire:initialized', function() {
    reinitializeLayoutSplitter();
    reinitializeCarousel();
});

document.addEventListener('livewire:navigated', function() {
    reinitializeLayoutSplitter();
    reinitializeCarousel();
});

Livewire.hook('element.init', ({ component, el }) => {
    reinitializeLayoutSplitter();
    reinitializeCarousel();
})

document.addEventListener('livewire:update', function() {
    reinitializeLayoutSplitter();
    reinitializeCarousel();
});

function reinitializeLayoutSplitter() {
    HSLayoutSplitter.autoInit();
}

function reinitializeCarousel() {
    HSCarousel.autoInit();
}

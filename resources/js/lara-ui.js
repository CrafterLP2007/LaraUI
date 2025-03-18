/* Listeners for livewire */
document.addEventListener('livewire:initialized', function() {
    reinitializeLayoutSplitter();
    reinitializeTooltip();
    reinitializeTreeView();
    reinitializeCarousel();
});

document.addEventListener('livewire:navigated', function() {
    reinitializeLayoutSplitter();
    reinitializeTooltip();
    reinitializeTreeView();
    reinitializeCarousel();
});

Livewire.hook('element.init', ({ component, el }) => {
    reinitializeLayoutSplitter();
    reinitializeTooltip();
    reinitializeTreeView();
    reinitializeCarousel();
})

document.addEventListener('livewire:update', function() {
    reinitializeLayoutSplitter();
    reinitializeTooltip();
    reinitializeTreeView();
    reinitializeCarousel();
});

function reinitializeLayoutSplitter() {
    HSLayoutSplitter.autoInit();
}

function reinitializeTooltip() {
    HSTooltip.autoInit();
}

function reinitializeTreeView() {
    HSTreeView.autoInit();
}

function reinitializeCarousel() {
    HSCarousel.autoInit();
}

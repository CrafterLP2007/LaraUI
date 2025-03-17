/* Listeners for livewire */
document.addEventListener('livewire:initialized', function() {
    reinitializeLayoutSplitter();
    reinitializeTooltip();
    reinitializePasswordInput();
    reinitializeTreeView();
    reinitializeCarousel();
});

document.addEventListener('livewire:navigated', function() {
    reinitializeLayoutSplitter();
    reinitializeTooltip();
    reinitializePasswordInput();
    reinitializeTreeView();
    reinitializeCarousel();
});

Livewire.hook('element.init', ({ component, el }) => {
    reinitializeLayoutSplitter();
    reinitializeTooltip();
    reinitializePasswordInput();
    reinitializeTreeView();
    reinitializeCarousel();
})

document.addEventListener('livewire:update', function() {
    reinitializeLayoutSplitter();
    reinitializeTooltip();
    reinitializePasswordInput();
    reinitializeTreeView();
    reinitializeCarousel();
});

function reinitializeLayoutSplitter() {
    HSLayoutSplitter.autoInit();
}

function reinitializeTooltip() {
    HSTooltip.autoInit();
}

function reinitializePasswordInput() {
    HSTogglePassword.autoInit();
}

function reinitializeTreeView() {
    HSTreeView.autoInit();
}

function reinitializeCarousel() {
    HSCarousel.autoInit();
}

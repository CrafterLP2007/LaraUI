@props([
    'uuid' => 'lara-ui-drag-' . Str::random(8),
])

<ul
    wire:ignore.self
    id="{{ $uuid }}"
    {{ $attributes->twMerge('flex flex-col relative min-h-[100px]') }}
    x-data="{
        dragTarget: null,
        ghostElement: null,
        init() {
            this.initItems();
            if (@js($attributes->wire('model')->value())) {
                $nextTick(() => this.sortInitialItems());
            }
        },
        initItems() {
            this.$el.querySelectorAll('li').forEach(item => {
                const handle = item.querySelector('.drag-handle');
                if (handle) {
                    handle.addEventListener('mousedown', () => {
                        item.draggable = true;
                    });
                    item.addEventListener('mouseup', () => {
                        item.draggable = false;
                    });
                }
            });
        },
        sortInitialItems() {
            const modelValue = @js($attributes->wire('model')->value());
            if (!modelValue) return;

            const order = $wire.get(modelValue);
            if (!order || !Array.isArray(order)) return;

            const list = this.$el;
            const items = Array.from(list.children);
            const orderedItems = [];

            order.forEach(uuid => {
                const item = items.find(item => item.dataset.uuid === uuid.toString());
                if (item) orderedItems.push(item);
            });

            orderedItems.forEach(item => list.appendChild(item));
        },
        createGhost(target) {
            this.ghostElement = target.cloneNode(true);
            this.ghostElement.classList.add('pointer-events-none', 'border-2', 'border-blue-500');
            this.ghostElement.classList.remove('first:rounded-t-lg', 'last:rounded-b-lg');
            this.ghostElement.style.height = `${target.offsetHeight}px`;
            return this.ghostElement;
        },
        removeGhost() {
            if (this.ghostElement) {
                this.ghostElement.remove();
                this.ghostElement = null;
            }
        },
        handleDragOver(e) {
            e.preventDefault();
            const target = e.target.closest('li');
            if (!target || target === this.dragTarget) return;

            this.removeGhost();
            const ghost = this.createGhost(this.dragTarget);

            const rect = target.getBoundingClientRect();
            const mouseY = e.clientY;
            const threshold = rect.top + (rect.height / 2);

            if (mouseY < threshold) {
                target.parentNode.insertBefore(ghost, target);
            } else {
                target.parentNode.insertBefore(ghost, target.nextSibling);
            }
        },
        handleDrop(e) {
            if (!this.dragTarget || !this.ghostElement) return;
            this.dragTarget.classList.remove('invisible');
            this.dragTarget.parentNode.insertBefore(this.dragTarget, this.ghostElement);
            this.removeGhost();
            this.updateOrder();
        },
        updateOrder() {
            const items = Array.from(this.$el.querySelectorAll('li')).map(item => item.dataset.uuid);
            const modelValue = @js($attributes->wire('model')->value());
            if (modelValue) {
                $wire.set(modelValue, items);
            }
        }
    }"
    @dragstart="dragTarget = $event.target; dragTarget.classList.add('invisible')"
    @dragend="removeGhost(); if (dragTarget) { dragTarget.classList.remove('invisible'); } dragTarget = null"
    @dragover.prevent="handleDragOver($event)"
    @drop.prevent="handleDrop($event)"
>
    {{ $slot }}
</ul>

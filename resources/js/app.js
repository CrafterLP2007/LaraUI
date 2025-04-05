window.LaraUIModal = () => {
    return {
        show: false,
        showActiveComponent: true,
        activeComponent: false,
        componentHistory: [],
        modalSize: null,
        listeners: [],

        getActiveComponentModalAttribute(key) {
            if (this.$wire.get('components')[this.activeComponent] !== undefined) {
                return this.$wire.get('components')[this.activeComponent]['modalAttributes'][key];
            }
        },

        closeModal(force = false, skipPreviousModals = 0, destroySkipped = false) {
            if(this.show === false) {
                return;
            }

            Livewire.dispatch('destroyComponent', {id: this.activeComponent});

            if (skipPreviousModals > 0) {
                for (var i = 0; i < skipPreviousModals; i++) {
                    if (destroySkipped) {
                        const id = this.componentHistory[this.componentHistory.length - 1];
                        Livewire.dispatch('destroyComponent', {id: id});
                    }
                    this.componentHistory.pop();
                }
            }

            const id = this.componentHistory.pop();

            if (id && !force) {
                this.setActiveModalComponent(id, true);
            } else {
                this.setShowPropertyTo(false);
            }
        },

        setActiveModalComponent(id, skip = false) {
            this.setShowPropertyTo(true);

            if (this.activeComponent === id) {
                return;
            }

            if (this.activeComponent !== false && skip === false) {
                this.componentHistory.push(this.activeComponent);
            }

            let focusableTimeout = 50;

            if (this.activeComponent === false) {
                this.activeComponent = id;
                this.showActiveComponent = true;
                this.modalSize = this.getActiveComponentModalAttribute('size');
            } else {
                this.showActiveComponent = false;

                focusableTimeout = 400;

                setTimeout(() => {
                    this.activeComponent = id;
                    this.showActiveComponent = true;
                    this.modalSize = this.getActiveComponentModalAttribute('size');
                }, 300);
            }

            this.$nextTick(() => {
                let focusable = this.$refs[id]?.querySelector('[autofocus]');
                if (focusable) {
                    setTimeout(() => {
                        focusable.focus();
                    }, focusableTimeout);
                }
            });
        },

        setShowPropertyTo(show) {
            this.show = show;

            if (show) {
                document.body.classList.add('overflow-y-hidden');
            } else {
                document.body.classList.remove('overflow-y-hidden');

                setTimeout(() => {
                    this.activeComponent = false;
                    this.$wire.resetState();
                }, 300);
            }
        },

        init() {
            this.modalSize = this.getActiveComponentModalAttribute('size');

            this.listeners.push(
                Livewire.on('closeModal', (data) => {
                    this.closeModal(data?.force ?? false, data?.skipPreviousModals ?? 0, data?.destroySkipped ?? false);
                })
            );

            this.listeners.push(
                Livewire.on('activeModalComponentChanged', ({id}) => {
                    this.setActiveModalComponent(id);
                })
            );
        },

        destroy() {
            this.listeners.forEach((listener) => {
                listener();
            });
        }
    };
}

window.LaraUIOffCanvas = () => {
    return {
        show: false,
        showActiveComponent: true,
        activeComponent: false,
        componentHistory: [],
        position: 'left',
        listeners: [],

        getActiveComponentAttribute(key) {
            if (this.$wire.get('components')[this.activeComponent] !== undefined) {
                return this.$wire.get('components')[this.activeComponent]['attributes'][key];
            }
        },

        closeOffcanvas(force = false, skipPreviousComponents = 0, destroySkipped = false) {
            if(this.show === false) {
                return;
            }

            Livewire.dispatch('destroyComponent', {id: this.activeComponent});

            if (skipPreviousComponents > 0) {
                for (var i = 0; i < skipPreviousComponents; i++) {
                    if (destroySkipped) {
                        const id = this.componentHistory[this.componentHistory.length - 1];
                        Livewire.dispatch('destroyComponent', {id: id});
                    }
                    this.componentHistory.pop();
                }
            }

            const id = this.componentHistory.pop();

            if (id && !force) {
                this.setActiveComponentTo(id, true);
            } else {
                this.setShowPropertyTo(false);
            }
        },

        setActiveComponentTo(id, skip = false) {
            this.setShowPropertyTo(true);

            if (this.activeComponent === id) {
                return;
            }

            if (this.activeComponent !== false && skip === false) {
                this.componentHistory.push(this.activeComponent);
            }

            let focusableTimeout = 50;

            if (this.activeComponent === false) {
                this.activeComponent = id;
                this.showActiveComponent = true;
                this.position = this.getActiveComponentAttribute('position');
            } else {
                this.showActiveComponent = false;

                focusableTimeout = 400;

                setTimeout(() => {
                    this.activeComponent = id;
                    this.showActiveComponent = true;
                    this.position = this.getActiveComponentAttribute('position');
                }, 300);
            }

            this.$nextTick(() => {
                let focusable = this.$refs[id]?.querySelector('[autofocus]');
                if (focusable) {
                    setTimeout(() => {
                        focusable.focus();
                    }, focusableTimeout);
                }
            });
        },

        setShowPropertyTo(show) {
            this.show = show;

            if (show) {
                document.body.classList.add('overflow-y-hidden');
            } else {
                document.body.classList.remove('overflow-y-hidden');

                setTimeout(() => {
                    this.activeComponent = false;
                    this.$wire.resetState();
                }, 300);
            }
        },

        init() {
            this.position = this.getActiveComponentAttribute('position');

            this.listeners.push(
                Livewire.on('closeOffcanvas', (data) => {
                    this.closeOffcanvas(data?.force ?? false, data?.skipPreviousComponents ?? 0, data?.destroySkipped ?? false);
                })
            );

            this.listeners.push(
                Livewire.on('activeOffCanvasComponentChanged', ({id}) => {
                    this.setActiveComponentTo(id);
                })
            );
        },

        destroy() {
            this.listeners.forEach((listener) => {
                listener();
            });
        }
    };
}


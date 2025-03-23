@props([
    'multiple' => false,
])

<div class="space-y-4"
     x-data="{
        multiple: {{ $multiple ? 'true' : 'false' }},
        dragOver: false,
        files: [],
        handleFileProgress(event, filename) {
            const file = this.files.find(f => f.filename === filename);
            if (file) {
                file.progress = event.detail.progress;
            }
        },
        handleFiles(event) {
            const newFiles = event.target.files || event.dataTransfer.files;
            if (!newFiles.length) return;

            // Clear existing files if not multiple
            if (!{{ $multiple ? 'true' : 'false' }}) {
                this.files = [];
                // Create new FileList with only the first file
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(newFiles[0]);
                $refs.input.files = dataTransfer.files;

                // Add only the first file to the preview
                const file = newFiles[0];
                this.files.push({
                    id: Date.now() + Math.random(),
                    filename: file.name,
                    progress: 0,
                    size: (file.size / 1024 / 1024).toFixed(2),
                    preview: file.type.startsWith('image/') ? URL.createObjectURL(file) : null
                });
            } else {
                Array.from(newFiles).forEach(file => {
                    this.files.push({
                        id: Date.now() + Math.random(),
                        filename: file.name,
                        progress: 0,
                        size: (file.size / 1024 / 1024).toFixed(2),
                        preview: file.type.startsWith('image/') ? URL.createObjectURL(file) : null
                    });
                });
            }

            // Listen for upload progress
            window.addEventListener('livewire-upload-progress', e => this.handleFileProgress(e, newFiles[0].name));
            window.addEventListener('livewire-upload-finish', e => this.handleFileProgress({ detail: { progress: 100 }}, newFiles[0].name));
        },
        removeFile(index) {
            if (this.files[index].preview) {
                URL.revokeObjectURL(this.files[index].preview);
            }
            this.files.splice(index, 1);

            // Clear the input file
            $refs.input.value = '';
            $refs.input.files = new DataTransfer().files;

            // Clear the Livewire model
            const modelName = $refs.input.getAttribute('wire:model') || $refs.input.getAttribute('wire:model.live');
            if (modelName) {
                $wire.set(modelName, null);
            }
        }
    }"
>
    <!-- Upload Area -->
    <div
        @dragover.prevent="dragOver = true"
        @dragleave.prevent="dragOver = false"
        @drop.prevent="
        dragOver = false;
        const dataTransfer = new DataTransfer();
        if (!$event.dataTransfer.files.length) return;

        // If multiple is false, only take the first file
        if (!{{ $multiple ? 'true' : 'false' }}) {
            dataTransfer.items.add($event.dataTransfer.files[0]);
            this.files = [];
        } else {
            Array.from($event.dataTransfer.files).forEach(file => {
                dataTransfer.items.add(file);
            });
        }

        $refs.input.files = dataTransfer.files;
        $refs.input.dispatchEvent(new Event('change'));
    "
        @click="$refs.input.click()"
        {{--
        class="cursor-pointer p-12 flex justify-center bg-white border-2 border-dashed transition-colors rounded-xl dark:bg-neutral-800"
        :class="dragOver ? 'border-blue-500' : 'border-gray-300 dark:border-neutral-600'"
        --}}
    >
        <input
            type="file"
            class="hidden"
            x-ref="input"
            @change="handleFiles($event)"
            {{ $attributes }}
            {{ $multiple ? 'multiple' : '' }}
        >

        {{--
        <div class="text-center">
            <span class="inline-flex justify-center items-center size-16 bg-gray-100 text-gray-800 rounded-full dark:bg-neutral-700 dark:text-neutral-200">
                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
            </span>

            <div class="mt-4 text-sm text-gray-600">
                <span class="font-medium text-gray-800 dark:text-neutral-200">Drop your files here or</span>
                <span class="text-blue-600 hover:text-blue-700 hover:underline">browse</span>
            </div>

            <p class="mt-1 text-xs text-gray-400 dark:text-neutral-400">
                Files up to 2MB
            </p>
        </div>
        --}}

        {{ $slot }}
    </div>

    <!-- Files Preview -->
    <template x-for="(file, index) in files" :key="file.id">
        <div class="p-3 bg-white border border-gray-300 rounded-xl dark:bg-neutral-800 dark:border-neutral-600">
            <div class="mb-1 flex justify-between items-center">
                <div class="flex items-center gap-x-3">
                    <span class="size-10 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg dark:border-neutral-700 dark:text-neutral-500">
                        <template x-if="file.preview">
                            <img :src="file.preview" class="rounded-lg w-full h-full object-cover">
                        </template>
                        <template x-if="!file.preview">
                            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </template>
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-800 dark:text-white" x-text="file.filename"></p>
                        <p class="text-xs text-gray-500 dark:text-neutral-500" x-text="`${file.size} MB`"></p>
                    </div>
                </div>
                <button @click="removeFile(index)" class="text-gray-500 hover:text-gray-800 focus:outline-none dark:text-neutral-500 dark:hover:text-neutral-200">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 6h18M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                    </svg>
                </button>
            </div>

            <!-- Progress Bar -->
            <div class="flex items-center gap-x-3 whitespace-nowrap">
                <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" :style="`width: ${file.progress}%`"></div>
                </div>
                <div class="w-10 text-end">
                    <span class="text-sm text-gray-800 dark:text-white" x-text="`${file.progress}%`"></span>
                </div>
            </div>
        </div>
    </template>
</div>

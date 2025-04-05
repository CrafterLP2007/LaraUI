@props([
    'placeholder' => '',
    'autoResize' => false,
])

<div
    wire:ignore
    x-data="{
        content: @entangle($attributes->wire('model')),
        editor: null,

        init() {
            this.editor = this.$refs.editor;

            this.editor.innerHTML = this.content || '';

            this.setupEditor();

            this.editor.addEventListener('click', (e) => {
                if (e.target.tagName === 'A') {
                    window.open(e.target.href, '_blank');
                }
            });

            this.editor.addEventListener('input', () => {
                this.content = this.editor.innerHTML;
            });

            this.$watch('content', (value) => {
                if (this.editor.innerHTML !== value) {
                    this.editor.innerHTML = value || '';
                }
            });
        },

        setupEditor() {
            this.handleBold();
            this.handleItalic();
            this.handleUnderline();
            this.handleStrike();
            this.handleLink();
            this.handleOrderedList();
            this.handleUnorderedList();
            this.handleBlockquote();
            this.handleCode();
        },

        handleBold() {
            this.$refs.bold.addEventListener('click', () => {
                document.execCommand('bold', false);
                this.editor.focus();
                this.updateContent();
            });
        },

        handleItalic() {
            this.$refs.italic.addEventListener('click', () => {
                document.execCommand('italic', false);
                this.editor.focus();
                this.updateContent();
            });
        },

        handleUnderline() {
            this.$refs.underline.addEventListener('click', () => {
                document.execCommand('underline', false);
                this.editor.focus();
                this.updateContent();
            });
        },

        handleStrike() {
            this.$refs.strike.addEventListener('click', () => {
                document.execCommand('strikeThrough', false);
                this.editor.focus();
                this.updateContent();
            });
        },

        handleLink() {
            this.$refs.link.addEventListener('click', () => {
                const selection = window.getSelection();
                const range = selection.getRangeAt(0);

                const linkElement = range.commonAncestorContainer.parentElement;
                if (linkElement && linkElement.tagName === 'A' && selection.toString()) {
                    const textContent = linkElement.textContent;
                    const textNode = document.createTextNode(textContent);
                    linkElement.parentNode.replaceChild(textNode, linkElement);
                } else if (selection.toString()) {
                    const url = prompt('Enter URL:');
                    if (url) {
                        document.execCommand('createLink', false, url);
                        const link = selection.anchorNode.parentElement;
                        if (link.tagName === 'A') {
                            link.setAttribute('target', '_blank');
                            link.setAttribute('rel', 'noopener noreferrer');
                        }
                    }
                }

                this.editor.focus();
                this.updateContent();
            });
        },

        handleOrderedList() {
            this.$refs.ol.addEventListener('click', () => {
                document.execCommand('insertOrderedList', false, null);
                const lists = this.editor.querySelectorAll('ol');
                lists.forEach(list => {
                    list.style.listStyleType = 'decimal';
                });
                this.editor.focus();
                this.updateContent();
            });
        },

        handleUnorderedList() {
            this.$refs.ul.addEventListener('click', () => {
                document.execCommand('insertUnorderedList', false, null);
                const lists = this.editor.querySelectorAll('ul');
                lists.forEach(list => {
                    list.style.listStyleType = 'disc';
                });
                this.editor.focus();
                this.updateContent();
            });
        },

        handleBlockquote() {
            this.$refs.blockquote.addEventListener('click', () => {
                const selection = window.getSelection();
                const range = selection.getRangeAt(0);
                const container = range.commonAncestorContainer.nodeType === 3
                    ? range.commonAncestorContainer.parentElement
                    : range.commonAncestorContainer;

                const blockquote = container.closest('blockquote');

                if (blockquote) {
                    // Remove blockquote but keep content
                    while (blockquote.firstChild) {
                        blockquote.parentNode.insertBefore(blockquote.firstChild, blockquote);
                    }
                    blockquote.remove();
                } else if (selection.toString().trim()) {
                    document.execCommand('formatBlock', false, 'blockquote');
                }

                this.editor.focus();
                this.updateContent();
            });
        },

        handleCode() {
            this.$refs.code.addEventListener('click', () => {
                const selection = window.getSelection();
                const range = selection.getRangeAt(0);

                const codeElement = range.commonAncestorContainer.parentElement;
                if (codeElement && codeElement.tagName === 'CODE') {
                    const textContent = codeElement.textContent;
                    const textNode = document.createTextNode(textContent);
                    codeElement.parentNode.replaceChild(textNode, codeElement);
                } else if (selection.toString()) {
                    const code = document.createElement('code');
                    code.textContent = selection.toString();
                    range.deleteContents();
                    range.insertNode(code);
                }

                this.editor.focus();
                this.updateContent();
            });
        },

        updateContent() {
            this.content = this.editor.innerHTML;
        }
    }"
    {{ $attributes->whereDoesntStartWith('wire:model') }}
    class="bg-white border border-gray-200 rounded-xl overflow-hidden dark:bg-neutral-800 dark:border-neutral-700"
>
    <div>
        <div
            class="sticky top-0 bg-white/80 dark:bg-neutral-900/80 backdrop-blur-md flex flex-wrap items-center justify-start gap-1 border-b border-gray-200 p-2 sm:p-3 dark:border-neutral-700">
            <button
                x-ref="bold"
                type="button"
                class="size-7 sm:size-8 inline-flex justify-center items-center text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
            >
                <svg class="size-3.5 sm:size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M14 12a4 4 0 0 0 0-8H6v8"/>
                    <path d="M15 20a4 4 0 0 0 0-8H6v8Z"/>
                </svg>
            </button>

            <button
                x-ref="italic"
                type="button"
                class="size-7 sm:size-8 inline-flex justify-center items-center text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
            >
                <svg class="size-3.5 sm:size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <line x1="19" x2="10" y1="4" y2="4"/>
                    <line x1="14" x2="5" y1="20" y2="20"/>
                    <line x1="15" x2="9" y1="4" y2="20"/>
                </svg>
            </button>

            <button
                x-ref="underline"
                type="button"
                class="size-7 sm:size-8 inline-flex justify-center items-center text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
            >
                <svg class="size-3.5 sm:size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M6 4v6a6 6 0 0 0 12 0V4"/>
                    <line x1="4" x2="20" y1="20" y2="20"/>
                </svg>
            </button>

            <button
                x-ref="strike"
                type="button"
                class="size-7 sm:size-8 inline-flex justify-center items-center text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
            >
                <svg class="size-3.5 sm:size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M16 4H9a3 3 0 0 0-2.83 4"/>
                    <path d="M14 12a4 4 0 0 1 0 8H6"/>
                    <line x1="4" x2="20" y1="12" y2="12"/>
                </svg>
            </button>

            <button
                x-ref="link"
                type="button"
                class="size-7 sm:size-8 inline-flex justify-center items-center text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
            >
                <svg class="size-3.5 sm:size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                </svg>
            </button>

            <button
                x-ref="ol"
                type="button"
                class="size-7 sm:size-8 inline-flex justify-center items-center text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
            >
                <svg class="size-3.5 sm:size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <line x1="10" x2="21" y1="6" y2="6"/>
                    <line x1="10" x2="21" y1="12" y2="12"/>
                    <line x1="10" x2="21" y1="18" y2="18"/>
                    <path d="M4 6h1v4"/>
                    <path d="M4 10h2"/>
                    <path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/>
                </svg>
            </button>

            <button
                x-ref="ul"
                type="button"
                class="size-7 sm:size-8 inline-flex justify-center items-center text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
            >
                <svg class="size-3.5 sm:size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <line x1="8" x2="21" y1="6" y2="6"/>
                    <line x1="8" x2="21" y1="12" y2="12"/>
                    <line x1="8" x2="21" y1="18" y2="18"/>
                    <line x1="3" x2="3.01" y1="6" y2="6"/>
                    <line x1="3" x2="3.01" y1="12" y2="12"/>
                    <line x1="3" x2="3.01" y1="18" y2="18"/>
                </svg>
            </button>

            <button
                x-ref="blockquote"
                type="button"
                class="size-7 sm:size-8 inline-flex justify-center items-center text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
            >
                <svg class="size-3.5 sm:size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="M17 6H3"/>
                    <path d="M21 12H8"/>
                    <path d="M21 18H8"/>
                    <path d="M3 12v6"/>
                </svg>
            </button>

            <button
                x-ref="code"
                type="button"
                class="size-7 sm:size-8 inline-flex justify-center items-center text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
            >
                <svg class="size-3.5 sm:size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="m18 16 4-4-4-4"/>
                    <path d="m6 8-4 4 4 4"/>
                    <path d="m14.5 4-5 16"/>
                </svg>
            </button>
        </div>

        <div
            x-ref="editor"
            contenteditable="true"
            {{ $attributes->twMerge('p-4 focus:outline-none prose prose-sm dark:prose-invert max-w-none dark:text-white [&::-webkit-scrollbar]:w-2
  [&::-webkit-scrollbar-track]:rounded-full
  [&::-webkit-scrollbar-track]:bg-gray-100
  [&::-webkit-scrollbar-thumb]:rounded-full
  [&::-webkit-scrollbar-thumb]:bg-gray-300
  dark:[&::-webkit-scrollbar-track]:bg-neutral-700
  dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 ' . ($autoResize ? 'overflow-y-hidden min-h-[10rem]' : 'overflow-auto h-40')) }}
        ></div>
    </div>
</div>

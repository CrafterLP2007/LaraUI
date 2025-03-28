<button :id="uuid"
        class="hs-accordion-toggle py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden"
        :aria-expanded="selectedAccordionItem === uuid ? 'true' : 'false'"
        :aria-controls="uuid"
        @click="selectedAccordionItem = selectedAccordionItem === uuid ? null : uuid"
        :class="{
            'text-blue-600 hover:text-blue-600 focus:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 dark:focus:text-blue-500': selectedAccordionItem === uuid,
            'text-gray-800 hover:text-gray-500 focus:text-gray-500 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400': selectedAccordionItem !== uuid
        }">
    <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
         :class="selectedAccordionItem === uuid ? 'hidden' : 'block'"
         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
         stroke-linejoin="round">
        <path d="M5 12h14"></path>
        <path d="M12 5v14"></path>
    </svg>
    <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
         :class="selectedAccordionItem === uuid ? 'block' : 'hidden'"
         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
         stroke-linejoin="round">
        <path d="M5 12h14"></path>
    </svg>
    {{ $slot }}
</button>

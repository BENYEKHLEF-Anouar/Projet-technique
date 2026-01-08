<!-- View Modal -->
<div id="view-note-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="view-note-modal-label">
  <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center">
    <div class="w-full flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
      
      <!-- Header -->
      <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
        <h3 id="view-note-title" class="font-bold text-lg text-gray-800 dark:text-white leading-tight pr-4">
          <!-- Title populated by JS -->
        </h3>
        <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#view-note-modal">
          <span class="sr-only">{{ __('Close') }}</span>
          <i data-lucide="x" class="shrink-0 size-4"></i>
        </button>
      </div>

      <!-- Body -->
      <div class="p-4 overflow-y-auto">
        
        <!-- Loading State -->
         <div id="view-modal-loading" class="text-center py-10">
            <div class="animate-spin inline-block w-8 h-8 border-[3px] border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500" role="status" aria-label="loading">
                <span class="sr-only">{{ __('Loading') }}...</span>
            </div>
        </div>

        <!-- Content -->
        <div id="view-modal-content" class="hidden space-y-4">
            
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-4 border-b border-gray-100 pb-3 dark:text-neutral-500 dark:border-neutral-700">
                <span id="view-note-user" class="font-medium"></span>
                <span>&bull;</span>
                <span id="view-note-date"></span>
            </div>

            <div id="view-note-image-container" class="mb-4 hidden">
                <img id="view-note-image" src="" alt="" class="w-full h-48 object-cover rounded-lg">
            </div>

            <div id="view-note-body" class="text-sm text-gray-700 whitespace-pre-line leading-relaxed dark:text-neutral-300"></div>

             <div id="view-note-categories" class="flex flex-wrap gap-2 pt-2"></div>
        </div>
      </div>

      <!-- Footer -->
      <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-overlay="#view-note-modal">
          {{ __('Close') }}
        </button>
      </div>
    </div>
  </div>
</div>
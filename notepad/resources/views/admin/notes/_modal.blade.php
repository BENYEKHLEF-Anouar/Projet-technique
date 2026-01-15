<div id="hs-slide-down-animation-modal"
  class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
  role="dialog" tabindex="-1" aria-labelledby="hs-slide-down-animation-modal-label">
  <div class="hs-overlay-open:mt-7 mt-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl pointer-events-auto">
      <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
        <h3 id="hs-slide-down-animation-modal-label" class="font-bold text-gray-800">
          {{ __('note.views.form_title') }}
        </h3>
        <button type="button"
          class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none"
          aria-label="Close" data-hs-overlay="#hs-slide-down-animation-modal">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
      <div class="p-4 overflow-y-auto">
        @include('admin.notes._form')
      </div>
      <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
        <button type="button"
          class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
          data-hs-overlay="#hs-slide-down-animation-modal">
          {{ __('note.views.cancel') }}
        </button>
        <button type="submit" form="noteForm"
          class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
          {{ __('note.views.save') }}
        </button>
      </div>
    </div>
  </div>
</div>
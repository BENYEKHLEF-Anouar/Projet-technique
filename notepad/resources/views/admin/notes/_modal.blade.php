{{-- Note Creation/Edit Modal --}}
<div id="hs-slide-down-animation-modal"
  class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none"
  role="dialog" tabindex="-1" aria-labelledby="hs-slide-down-animation-modal-label">
  <div
    class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
    <div
      class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">

      {{-- Modal Header --}}
      <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
        <h3 id="hs-slide-down-animation-modal-label" class="font-bold text-gray-800 dark:text-white">
          {{ __('note.views.add_note') }}
        </h3>
        <button type="button"
          class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
          aria-label="Close" data-hs-overlay="#hs-slide-down-animation-modal">
          <span class="sr-only">{{ __('note.views.close') }}</span>
          <i data-lucide="x" class="size-4"></i>
        </button>
      </div>

      {{-- Modal Body --}}
      <div class="p-4 overflow-y-auto">
        <form id="noteForm" action="{{ route('notes.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="space-y-4">
            {{-- Name --}}
            <div>
              <label for="name"
                class="block mb-2 text-sm font-medium dark:text-white">{{ __('note.attributes.name') }}</label>
              <input type="text" name="name" id="name"
                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                placeholder="{{ __('note.views.name_placeholder') }}">
              <span id="error-name" class="error-msg text-xs text-red-600 mt-1 block"></span>
            </div>

            {{-- Content --}}
            <div>
              <label for="content"
                class="block mb-2 text-sm font-medium dark:text-white">{{ __('note.attributes.content') }}</label>
              <textarea name="content" id="content" rows="3"
                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                placeholder="{{ __('note.views.content_placeholder') }}"></textarea>
              <span id="error-content" class="error-msg text-xs text-red-600 mt-1 block"></span>
            </div>

            {{-- Categories --}}
            <div>
              <label
                class="block mb-2 text-sm font-medium dark:text-white">{{ __('note.attributes.categories') }}</label>
              <div class="grid grid-cols-2 gap-2">
                @foreach($categories as $cat)
                  <div class="flex">
                    <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}" id="active-cat-{{ $cat->id }}"
                      class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                    <label for="active-cat-{{ $cat->id }}" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">
                      {{ Lang::has('category.names.' . $cat->name) ? __('category.names.' . $cat->name) : $cat->name }}
                    </label>
                  </div>
                @endforeach
              </div>
              <span id="error-category_ids" class="error-msg text-xs text-red-600 mt-1 block"></span>
            </div>

            {{-- Image --}}
            <div>
              <label class="block mb-2 text-sm font-medium dark:text-white">{{ __('note.attributes.image') }}</label>
              <input type="file" name="image" id="note-image"
                class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4 dark:file:bg-neutral-700 dark:file:text-neutral-400">
              <span id="error-image" class="error-msg text-xs text-red-600 mt-1 block"></span>

              <div id="image-preview" class="mt-2 hidden">
                <p class="text-sm text-gray-500 mb-1">{{ __('note.views.preview') }}</p>
                <img src="" class="h-20 w-auto rounded-md object-cover border dark:border-neutral-700">
              </div>
            </div>
          </div>

          {{-- Modal Footer --}}
          <div
            class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 mt-4 dark:border-neutral-700">
            <button type="button" data-hs-overlay="#hs-slide-down-animation-modal"
              class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
              {{ __('note.views.cancel') }}
            </button>
            <button type="submit"
              class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
              {{ __('note.views.save') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
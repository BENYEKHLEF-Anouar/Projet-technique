<!-- Create/Edit Modal -->
<div id="form-note-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="form-note-modal-label">
  <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center">
    <div class="w-full flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
      
      <!-- Header -->
      <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
        <h3 id="form-note-modal-label" class="font-bold text-gray-800 dark:text-white">
          {{ __('Create Note') }}
        </h3>
        <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#form-note-modal">
          <span class="sr-only">{{ __('Close') }}</span>
          <i data-lucide="x" class="shrink-0 size-4"></i>
        </button>
      </div>

      <!-- Body -->
      <div class="p-4 overflow-y-auto">
        <form id="note-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="note-id" name="id">
            <input type="hidden" id="form-method" name="_method" value="POST">
            
            <!-- Error Container -->
            <div id="form-errors" class="hidden mb-4 p-4 bg-red-50 text-red-700 rounded-lg">
                 <div class="flex">
                    <div class="shrink-0">
                        <i data-lucide="alert-circle" class="h-5 w-5 text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">{{ __('There were errors with your submission') }}</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <div id="error-messages"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Name -->
            <div class="mb-4">
                <label for="note-name" class="block text-sm font-medium mb-2 dark:text-white">{{ __('Title') }}</label>
                <input type="text" id="note-name" name="name" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="{{ __('Enter note title') }}" required>
                 <p id="error-name" class="text-xs text-red-600 mt-2 hidden"></p>
            </div>

            <!-- Content -->
            <div class="mb-4">
                <label for="note-content" class="block text-sm font-medium mb-2 dark:text-white">{{ __('Content') }}</label>
                <textarea id="note-content" name="content" rows="4" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="{{ __('Write your note here...') }}" required></textarea>
                 <p id="error-content" class="text-xs text-red-600 mt-2 hidden"></p>
            </div>

            <!-- Categories -->
            <div class="mb-4">
                 <label class="block text-sm font-medium mb-2 dark:text-white">{{ __('Categories') }}</label>
                <div class="grid grid-cols-2 gap-2" id="categories-container">
                    @foreach($categories as $category)
                        <label class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                            <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
                <p id="error-category_ids" class="text-xs text-red-600 mt-2 hidden"></p>
            </div>

            <!-- Image -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 dark:text-white">{{ __('Cover Image') }}</label>
                
                <!-- Current Image (for edit) -->
                <div id="current-image-container" class="hidden mb-2 relative group w-full h-32">
                    <img id="current-image" src="" class="w-full h-full object-cover rounded-lg">
                    <div class="absolute inset-0 bg-black/40 hidden group-hover:flex items-center justify-center rounded-lg">
                        <span class="text-white text-xs font-semibold">{{ __('Current Image') }}</span>
                    </div>
                </div>

                <div class="flex items-center justify-center w-full">
                    <label for="note-image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-200 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-neutral-800">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i data-lucide="cloud-upload" class="w-8 h-8 mb-2 text-gray-500 dark:text-neutral-400"></i>
                            <p class="mb-2 text-sm text-gray-500 dark:text-neutral-400"><span class="font-semibold">{{ __('Click to upload') }}</span></p>
                        </div>
                        <input id="note-image" name="image" type="file" class="hidden" accept="image/*" onchange="handleImagePreview(this)">
                    </label>
                </div>
                <!-- Image Preview -->
                <div id="image-preview-container" class="mt-4 hidden relative group">
                    <img id="image-preview" src="" alt="Preview" class="w-full h-40 object-cover rounded-lg">
                    <button type="button" onclick="clearImagePreview()" class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </form>
      </div>

      <!-- Footer -->
      <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-overlay="#form-note-modal">
          {{ __('Cancel') }}
        </button>
        <button type="submit" form="note-form" id="submit-btn" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
          {{ __('Save Note') }}
        </button>
      </div>
    </div>
  </div>
</div>
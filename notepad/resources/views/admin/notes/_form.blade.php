<form id="noteForm" action="{{ route('notes.store') }}" method="POST" enctype="multipart/form-data"
    data-success="{{ __('note.views.success') }}">
    @csrf
    <div class="space-y-4">
        <!-- Name -->
        <div class="mb-4 sm:mb-8">
            <label for="name" class="block mb-2 text-sm font-medium">{{ __('note.attributes.name') }}</label>
            <input type="text" id="name" name="name" required
                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                placeholder="{{ __('note.views.name_placeholder') }}">
        </div>

        <!-- Content -->
        <div class="mb-4 sm:mb-8">
            <label for="content" class="block mb-2 text-sm font-medium">{{ __('note.attributes.content') }}</label>
            <div class="mt-1">
                <textarea id="content" name="content" required rows="3"
                    class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                    placeholder="{{ __('note.views.content_placeholder') }}"></textarea>
            </div>
        </div>

        <!-- Image -->
        <div class="mb-4 sm:mb-8">
            <label for="image" class="block mb-2 text-sm font-medium">{{ __('note.attributes.image') }}</label>
            <input type="file" name="image" id="image" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                file:bg-gray-50 file:border-0
                file:me-4
                file:py-3 file:px-4">
            <div id="image-preview" class="mt-2 hidden">
                <p class="text-sm text-gray-500 mb-1">Current Image:</p>
                <img src="" alt="Preview" class="h-20 w-auto rounded-md object-cover border">
            </div>
        </div>

        <!-- Categories -->
        <div class="mb-4 sm:mb-8">
            <label class="block mb-2 text-sm font-medium">{{ __('note.attributes.categories') }}</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach($categories as $cat)
                    <div class="flex">
                        <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}" id="cat-{{ $cat->id }}"
                            class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <label for="cat-{{ $cat->id }}"
                            class="text-sm text-gray-500 ms-3">{{ $cat->name ?? $cat->nom }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</form>
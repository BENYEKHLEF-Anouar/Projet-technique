@extends('layouts.admin')

@section('header-title', isset($note) ? 'Edit Note' : 'Create Note') <!-- ternary operator in PHP -->

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">{{ isset($note) ? 'Edit Note' : 'Create New Note' }}</h2>
        <p class="text-gray-600 mt-1">{{ isset($note) ? 'Update note details below' : 'Fill in the details to create a new note' }}</p>
    </div>

    <form action="{{ isset($note) ? route('admin.notes.update', $note->id) : route('admin.notes.store') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        @csrf
        @if(isset($note))
            @method('PUT')
        @endif

        <div class="p-6 space-y-6">
            <!-- Note Title -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Note Title <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $note->name ?? '') }}" 
                       required
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 @error('name') border-red-500 @enderror" 
                       placeholder="Enter note title...">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Content
                </label>
                <textarea id="content" 
                          name="content" 
                          rows="8" 
                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 @error('content') border-red-500 @enderror" 
                          placeholder="Write your note content here...">{{ old('content', $note->content ?? '') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Author/User -->
            <!-- Author/User field removed: now defaults to authenticated user -->

            <!-- Categories -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Categories
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($categories as $category)
                        <label class="relative flex items-start p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                            <input type="checkbox" 
                                   name="category_ids[]" 
                                   value="{{ $category->id }}" 
                                   class="mt-0.5 rounded text-indigo-600 focus:ring-indigo-500"
                                   {{ (isset($note) && $note->categories->contains($category->id)) || (is_array(old('category_ids')) && in_array($category->id, old('category_ids'))) ? 'checked' : '' }}>
                            <span class="ml-3 text-sm text-gray-700">{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('category_ids')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Cover Image
                </label>
                
                @if(isset($note) && $note->image)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Current image:</p>
                        <img src="{{ asset('storage/' . $note->image) }}" 
                             alt="Current cover" 
                             class="w-48 h-32 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif

                <div class="flex items-center gap-4">
                    <label class="flex-1 flex flex-col items-center px-4 py-6 bg-white border-2 border-gray-200 border-dashed rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <i data-lucide="upload" class="w-8 h-8 text-gray-400 mb-2"></i>
                        <span class="text-sm text-gray-600">Click to upload or drag and drop</span>
                        <span class="text-xs text-gray-500 mt-1">PNG, JPG or GIF (MAX. 2MB)</span>
                        <input type="file" 
                               name="image" 
                               accept="image/*" 
                               class="hidden" id="image-input">
                        <span id="image-indicator" class="mt-2 text-xs text-indigo-600 font-medium"></span>
                    </label>
                </div>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var imageInput = document.getElementById('image-input');
                    var indicator = document.getElementById('image-indicator');
                    if (imageInput && indicator) {
                        imageInput.addEventListener('change', function() {
                            if (imageInput.files && imageInput.files[0]) {
                                indicator.textContent = 'Selected: ' + imageInput.files[0].name;
                            } else {
                                indicator.textContent = '';
                            }
                        });
                    }
                });
                </script>
                @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('admin.notes.index') }}" 
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                {{ isset($note) ? 'Update Note' : 'Create Note' }}
            </button>
        </div>
    </form>
</div>
@endsection

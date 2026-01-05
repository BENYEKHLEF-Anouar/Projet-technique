@extends('layouts.app')

@section('content')
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-lg shadow-gray-200/50 overflow-hidden dark:bg-slate-900 dark:border-gray-700">
                    <!-- Header -->
                    <div
                        class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700 bg-gray-50/50">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                My Notes
                            </h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Organize and manage your content efficiently.
                            </p>
                        </div>

                        <!-- Search & Filter -->
                        <div class="hidden sm:flex sm:items-center sm:gap-x-2">
                            <input type="text" id="search-input"
                                class="py-2 px-3 block w-48 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                placeholder="Search notes...">

                            <select id="category-filter"
                                class="py-2 px-3 pe-9 block w-40 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <button type="button" data-hs-overlay="#hs-create-note-modal"
                                class="py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-lg border border-transparent font-semibold bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800 shadow-md">
                                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                </svg>
                                New Note
                            </button>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Table Container -->
                    <div id="notes-table-container">
                        @include('admin.notes.partials.list')
                    </div>
                    <!-- End Table Container -->
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div id="hs-create-note-modal"
        class="hs-overlay hidden w-full h-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
        <div
            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-2xl sm:w-full m-3 sm:mx-auto">
            <div
                class="bg-white border border-gray-200 rounded-2xl shadow-2xl dark:bg-slate-900 dark:border-gray-700 pointer-events-auto flex flex-col max-h-[90vh]">

                <!-- Header -->
                <div
                    class="flex justify-between items-center py-4 px-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 rounded-t-2xl">
                    <h3 id="modal-title" class="text-lg font-bold text-gray-800 dark:text-white">
                        New Note
                    </h3>
                    <button type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                        data-hs-overlay="#hs-create-note-modal">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6 overflow-y-auto custom-scrollbar">
                    <form id="note-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="note-id" name="id">
                        <input type="hidden" name="_method" id="form-method" value="POST">

                        <div class="grid gap-6">
                            <!-- Name -->
                            <div class="group">
                                <label for="name" class="block text-sm font-medium mb-2 dark:text-white">Note Title</label>
                                <div class="relative">
                                    <input type="text" id="name" name="name"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 shadow-sm transition-all"
                                        placeholder="Enter a descriptive title..." required>
                                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                        <svg class="hidden group-[.valid]:block size-4 text-teal-500"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </div>
                                </div>
                                <p id="error-name" class="text-xs text-red-600 mt-2 hidden"></p>
                            </div>

                            <!-- Categories (Checkbox Grid) -->
                            <div
                                class="bg-gray-50 dark:bg-slate-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                                <label class="block text-sm font-medium mb-3 dark:text-white">Categories</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    @foreach($categories as $category)
                                        <label for="category-{{ $category->id }}"
                                            class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-800 transition-all shadow-sm">
                                            <input type="checkbox" id="category-{{ $category->id }}" name="categories[]"
                                                value="{{ $category->id }}"
                                                class="shrink-0 mt-0.5 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                            <span
                                                class="text-sm text-gray-600 ms-2 dark:text-gray-400 font-medium select-none">{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Content -->
                            <div>
                                <label for="content" class="block text-sm font-medium mb-2 dark:text-white">Content</label>
                                <textarea id="content" name="content" rows="6"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 shadow-sm transition-all"
                                    placeholder="Write your note content here..."></textarea>
                            </div>

                            <!-- Image Upload -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Cover Image</label>
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <!-- URL Input -->
                                    <div class="grow">
                                        <div class="relative">
                                            <input type="url" id="image_url" name="image_url"
                                                placeholder="https://example.com/image.jpg"
                                                class="py-3 px-4 ps-11 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-neutral-600">
                                            <div
                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                                <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M15 3h6v6" />
                                                    <path d="M10 14 21 3" />
                                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center self-center text-xs text-gray-400 font-medium">OR</div>

                                    <!-- Helper for File Upload - Styled Label -->
                                    <div class="w-full sm:w-auto">
                                        <label for="image"
                                            class="group p-0.5 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors w-full sm:w-auto inline-flex cursor-pointer border border-transparent">
                                            <span
                                                class="py-2.5 px-4 inline-flex items-center justify-center gap-x-2 rounded-md bg-white text-gray-700 text-sm font-medium shadow-sm hover:text-blue-600 dark:bg-slate-900 dark:text-gray-200 dark:hover:text-blue-500 w-full">
                                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                    <polyline points="17 8 12 3 7 8" />
                                                    <line x1="12" x2="12" y1="3" y2="15" />
                                                </svg>
                                                Upload File
                                            </span>
                                            <input type="file" id="image" name="image" class="hidden">
                                        </label>
                                    </div>
                                </div>
                                <div id="current-image"
                                    class="mt-4 hidden p-2 border border-gray-200 rounded-lg bg-gray-50 dark:bg-slate-900 dark:border-gray-700 inline-block">
                                    <p class="text-xs text-gray-500 mb-2 font-medium uppercase tracking-wide">Preview</p>
                                    <img src="" class="h-32 w-auto object-cover rounded-md shadow-sm">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div
                    class="flex justify-end items-center gap-x-2 py-4 px-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 rounded-b-2xl">
                    <button type="button"
                        class="py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-lg border border-gray-200 font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
                        data-hs-overlay="#hs-create-note-modal">
                        Cancel
                    </button>
                    <button type="button" id="save-note-btn"
                        class="py-2.5 px-6 inline-flex justify-center items-center gap-2 rounded-lg border border-transparent font-semibold bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800 shadow-md shadow-blue-500/30 hover:shadow-blue-500/50">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Save Note
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Note Modal -->
    <div id="hs-view-note-modal"
        class="hs-overlay hidden w-full h-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
        <div
            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-2xl sm:w-full m-3 sm:mx-auto">
            <div
                class="bg-white border border-gray-200 rounded-2xl shadow-2xl dark:bg-slate-900 dark:border-gray-700 pointer-events-auto flex flex-col max-h-[90vh]">

                <!-- Header -->
                <div
                    class="flex justify-between items-center py-4 px-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 rounded-t-2xl">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <svg class="size-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                        </svg>
                        View Note
                    </h3>
                    <button type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                        data-hs-overlay="#hs-view-note-modal">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6 overflow-y-auto custom-scrollbar">
                    <div class="flex flex-col gap-6">
                        <div>
                            <h4 class="text-2xl font-bold text-gray-800 dark:text-white leading-tight" id="view-name"></h4>
                            <div class="mt-2 flex items-center gap-4">
                                <span
                                    class="inline-flex items-center gap-1.5 py-1 px-3 rounded-md text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200"
                                    id="view-categories-badge">
                                    <span id="view-categories"></span>
                                </span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10" />
                                        <circle cx="12" cy="10" r="3" />
                                        <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662" />
                                    </svg>
                                    <span id="view-author"></span>
                                </span>
                            </div>
                        </div>

                        <div id="view-image-container"
                            class="hidden rounded-xl overflow-hidden shadow-sm border border-gray-100 dark:border-gray-700">
                            <img id="view-image" src="" class="w-full h-64 object-cover">
                        </div>

                        <div class="prose prose-blue dark:prose-invert max-w-none">
                            <div
                                class="p-5 bg-gray-50 rounded-xl dark:bg-slate-800/50 border border-gray-100 dark:border-gray-700">
                                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed"
                                    id="view-content"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div
                    class="flex justify-end items-center gap-x-2 py-4 px-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 rounded-b-2xl">
                    <button type="button"
                        class="py-2.5 px-6 inline-flex justify-center items-center gap-2 rounded-lg border border-gray-200 font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
                        data-hs-overlay="#hs-view-note-modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/admin-notes.js'])
    @endpush
@endsection
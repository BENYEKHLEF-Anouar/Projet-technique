@extends('layouts.admin')

@section('content')
    <div x-data="noteManager({ 
        initialNotes: {{ Js::from($notes->items()) }}, 
        initialPagination: {{ Js::from($notes->toArray()) }},
        initialCategoryId: '{{ request('category_id', '') }}',
        csrf: '{{ csrf_token() }}' 
    })"
        class="container mx-auto p-4 space-y-6">

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h1 class="text-2xl font-bold text-gray-800">{{ __('note.views.title') }}</h1>

                <button type="button" @click="openCreateModal()"
                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    {{ __('note.views.add_note') }}
                </button>
            </div>

            <!-- Filters -->
            <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                <div class="max-w-sm w-full relative">
                    <input type="text" x-model="search"
                        class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="{{ __('note.views.search_placeholder') }}">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                        <i data-lucide="search" class="shrink-0 size-4 text-gray-400 dark:text-neutral-500"></i>
                    </div>
                </div>

                <!-- Search Box (Combobox) -->
                <div class="max-w-sm w-full">
                    <div class="relative" data-hs-combo-box='{
                        "isOpenOnFocus": true
                    }'>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 z-20">
                                <i data-lucide="filter" class="shrink-0 size-4 text-gray-400 dark:text-neutral-500"></i>
                            </div>
                            <input class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" 
                                type="text" role="combobox" aria-expanded="false" 
                                placeholder="{{ __('All Categories') }}" 
                                value="{{ $categories->firstWhere('id', request('category_id'))?->name ?? '' }}" 
                                data-hs-combo-box-input="">
                        </div>

                        <!-- Dropdown -->
                        <div class="absolute z-50 w-full bg-white border border-gray-200 rounded-lg shadow-xl p-2 max-h-72 overflow-hidden overflow-y-auto dark:bg-neutral-800 dark:border-neutral-700" 
                            style="display: none;" data-hs-combo-box-output="">
                            <div data-hs-combo-box-output-items-wrapper="">
                                <!-- All Option -->
                                <div data-hs-combo-box-output-item tabindex="0">
                                    <span class="flex items-center cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-200" data-value="">
                                        <div class="flex items-center w-full">
                                            <div data-hs-combo-box-search-text data-hs-combo-box-value>{{ __('All Categories') }}</div>
                                        </div>
                                    </span>
                                </div>
                                <!-- Categories -->
                                @foreach($categories as $cat)
                                    <div data-hs-combo-box-output-item tabindex="0">
                                        <span class="flex items-center cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-200" data-value="{{ $cat->id }}">
                                            <div class="flex items-center w-full">
                                                <div data-hs-combo-box-search-text data-hs-combo-box-value>{{ trans()->has('category.names.' . $cat->name) ? __('category.names.' . $cat->name) : $cat->name }}</div>
                                            </div>
                                            <span class="hidden hs-combo-box-selected:block">
                                                <i data-lucide="check" class="shrink-0 size-3.5 text-blue-600 dark:text-blue-500"></i>
                                            </span>
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div x-show="loading" class="text-center py-4 text-gray-500">
                Scanning notes...
            </div>

            <!-- Table -->
            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div
                            class="border rounded-lg shadow-sm overflow-hidden dark:border-neutral-700 dark:shadow-neutral-900">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                <thead class="bg-gray-50 dark:bg-neutral-700">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            {{ __('note.attributes.name') }}</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            {{ __('note.attributes.content') }}</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            {{ __('note.attributes.categories') }}</th>

                                        <th scope="col"
                                            class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            {{ __('note.views.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                    <template x-for="note in notes" :key="note.id">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200"
                                                x-text="note.name"></td>
                                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-neutral-200">
                                                <div class="truncate max-w-xs" x-text="note.content"></div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-neutral-200">
                                                <div class="flex flex-wrap gap-1">
                                                    <template x-for="cat in note.categories" :key="cat.id">
                                                        <span
                                                            class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500"
                                                            x-text="cat.name"></span>
                                                    </template>
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                                <div class="flex justify-end gap-x-2">
                                                    <!-- Edit -->
                                                    <button type="button" @click="openEditModal(note)"
                                                        class="inline-flex items-center justify-center size-8 rounded-lg text-blue-600 hover:bg-blue-50 dark:text-blue-500 dark:hover:bg-blue-900/30"
                                                        title="{{ __('note.views.edit') }}">
                                                        <i data-lucide="pencil" class="size-4"></i>
                                                    </button>
                                                    <!-- Delete -->
                                                    <button type="button" @click="deleteNote(note.id)"
                                                        class="inline-flex items-center justify-center size-8 rounded-lg text-red-600 hover:bg-red-50 dark:text-red-500 dark:hover:bg-red-900/30"
                                                        title="{{ __('note.views.delete') }}">
                                                        <i data-lucide="trash-2" class="size-4"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <template x-if="notes.length === 0">
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                                No notes found.
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <!-- Table Footer (Pagination) -->
                        <div x-show="pagination.last_page > 1"
                            class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-neutral-400">
                                    Showing <span class="font-semibold text-gray-800 dark:text-neutral-200" x-text="pagination.from"></span> 
                                    to <span class="font-semibold text-gray-800 dark:text-neutral-200" x-text="pagination.to"></span> 
                                    of <span class="font-semibold text-gray-800 dark:text-neutral-200" x-text="pagination.total"></span> results
                                </p>
                            </div>

                            <div>
                                <nav class="flex items-center gap-x-1" aria-label="Pagination">
                                    <button type="button" 
                                        @click="changePage(currentPage - 1)"
                                        :disabled="currentPage === 1"
                                        class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m15 18-6-6 6-6" />
                                        </svg>
                                        <span>Previous</span>
                                    </button>

                                    <div class="flex items-center gap-x-1">
                                        <template x-for="page in pages" :key="page">
                                            <button type="button" 
                                                @click="changePage(page)"
                                                :class="currentPage === page ? 'bg-gray-200 text-gray-800 dark:bg-neutral-700 dark:text-white' : 'text-gray-800 hover:bg-gray-100 dark:text-white dark:hover:bg-neutral-800'"
                                                class="min-h-[38px] min-w-[38px] flex justify-center items-center py-2 px-3 text-sm rounded-lg focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none"
                                                x-text="page">
                                            </button>
                                        </template>
                                    </div>

                                    <button type="button" 
                                        @click="changePage(currentPage + 1)"
                                        :disabled="currentPage === pagination.last_page"
                                        class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                                        <span>Next</span>
                                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m9 18 6-6-6-6" />
                                        </svg>
                                    </button>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Custom Alpine Modal -->
            <div x-show="showModal" style="display: none;"
                class="fixed inset-0 z-[80] overflow-x-hidden overflow-y-auto w-full h-full flex items-center justify-center bg-gray-900/50 backdrop-blur-sm"
                x-transition>

                <div class="bg-white border border-gray-200 shadow-sm rounded-xl w-full max-w-lg mx-4 flex flex-col pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70"
                    @click.outside="closeModal()">

                    <!-- Modal Header -->
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
                        <h3 class="font-bold text-gray-800 dark:text-white"
                            x-text="isEdit ? '{{ __('note.views.edit') }}' : '{{ __('note.views.add_note') }}'"></h3>
                        <button type="button"
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                            aria-label="Close" @click="closeModal()">
                            <span class="sr-only">Close</span>
                            <i data-lucide="x" class="size-4"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-4 overflow-y-auto">
                        <form @submit.prevent="submitForm">
                            <div class="space-y-4">
                                <!-- Name -->
                                <div>
                                    <label for="name"
                                        class="block mb-2 text-sm font-medium dark:text-white">{{ __('note.attributes.name') }}</label>
                                    <input type="text" x-model="formData.name"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                        placeholder="{{ __('note.views.name_placeholder') }}">
                                    <span x-text="errors.name" class="text-xs text-red-600 mt-1 block"></span>
                                </div>

                                <!-- Content -->
                                <div>
                                    <label for="content"
                                        class="block mb-2 text-sm font-medium dark:text-white">{{ __('note.attributes.content') }}</label>
                                    <textarea x-model="formData.content" rows="3"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                        placeholder="{{ __('note.views.content_placeholder') }}"></textarea>
                                    <span x-text="errors.content" class="text-xs text-red-600 mt-1 block"></span>
                                </div>

                                <!-- Categories -->
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-medium dark:text-white">{{ __('note.attributes.categories') }}</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach($categories as $cat)
                                            <div class="flex">
                                                <input type="checkbox" :value="{{ $cat->id }}" x-model="formData.category_ids"
                                                    id="active-cat-{{ $cat->id }}"
                                                    class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                                <label for="active-cat-{{ $cat->id }}"
                                                    class="text-sm text-gray-500 ms-3 dark:text-neutral-400">
                                                    {{ trans()->has('category.names.' . $cat->name) ? __('category.names.' . $cat->name) : $cat->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Image -->
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-medium dark:text-white">{{ __('note.attributes.image') }}</label>
                                    <input type="file" id="note-image" @change="handleFileUpload"
                                        class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4 dark:file:bg-neutral-700 dark:file:text-neutral-400">
                                    <span x-text="errors.image" class="text-xs text-red-600 mt-1 block"></span>

                                    <div x-show="imagePreview" class="mt-2">
                                        <p class="text-sm text-gray-500 mb-1">Preview:</p>
                                        <img :src="imagePreview"
                                            class="h-20 w-auto rounded-md object-cover border dark:border-neutral-700">
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div
                                class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 mt-4 dark:border-neutral-700">
                                <button type="button" @click="closeModal()"
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
@endsection
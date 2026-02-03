@extends('layouts.admin')

@section('content')
    <div x-data="noteManager({ 
        initialNotes: {{ Js::from($notes->items()) }}, 
        initialPagination: {{ Js::from($notes->toArray()) }},
        initialCategoryId: '{{ request('category_id', '') }}',
        csrf: '{{ csrf_token() }}',
        deleteConfirmMessage: '{{ __('note.views.delete_confirm') }}',
        currentUserId: {{ auth()->id() ?? 'null' }},
        userRole: '{{ auth()->user()->role ?? 'user' }}'
    })"
        class="container mx-auto p-4 space-y-6">

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h1 class="text-2xl font-bold text-gray-800">{{ __('note.views.title') }}</h1>

            @can('create-note')
                <button type="button" @click="openCreateModal()"
                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    {{ __('note.views.add_note') }}
                </button>
            @endcan
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
                                placeholder="{{ __('category.views.all') }}" 
                                value="{{ $categories->firstWhere('id', request('category_id')) ? (Lang::has('category.names.' . $categories->firstWhere('id', request('category_id'))->name) ? __('category.names.' . $categories->firstWhere('id', request('category_id'))->name) : $categories->firstWhere('id', request('category_id'))->name) : '' }}" 
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
                                            <div data-hs-combo-box-search-text data-hs-combo-box-value>{{ __('category.views.all') }}</div>
                                        </div>
                                    </span>
                                </div>
                                <!-- Categories -->
                                @foreach($categories as $cat)
                                    <div data-hs-combo-box-output-item tabindex="0">
                                        <span class="flex items-center cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-200" data-value="{{ $cat->id }}">
                                            <div class="flex items-center w-full">
                                                <div data-hs-combo-box-search-text data-hs-combo-box-value>{{ Lang::has('category.names.' . $cat->name) ? __('category.names.' . $cat->name) : $cat->name }}</div>
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
                {{ __('note.views.scanning_notes') }}
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
                                    @include('admin.notes._table_body')
                                </tbody>
                            </table>
                        </div>

                        <!-- Table Footer (Pagination) -->
                        <div x-show="pagination.last_page > 1"
                            class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-neutral-400">
                                    {{ __('note.views.showing') }} <span class="font-semibold text-gray-800 dark:text-neutral-200" x-text="pagination.from"></span> 
                                    {{ __('note.views.to') }} <span class="font-semibold text-gray-800 dark:text-neutral-200" x-text="pagination.to"></span> 
                                    {{ __('note.views.of') }} <span class="font-semibold text-gray-800 dark:text-neutral-200" x-text="pagination.total"></span> {{ __('note.views.results') }}
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
                                        <span>{{ __('note.views.previous') }}</span>
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
                                        <span>{{ __('note.views.next') }}</span>
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

        @include('admin.notes._modal')

        </div>
@endsection
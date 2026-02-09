@extends('layouts.admin')

@section('content')
    <div class="p-4 space-y-6">

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h1 class="text-2xl font-bold text-gray-800">{{ __('note.views.title') }}</h1>

            @can('create-note')
                <button type="button" id="openModal"
                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    {{ __('note.views.add_note') }}
                </button>
            @endcan
        </div>

            <!-- Filters -->
            <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                <div class="max-w-sm w-full relative">
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="{{ __('note.views.search_placeholder') }}">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                        <i data-lucide="search" class="shrink-0 size-4 text-gray-400 dark:text-neutral-500"></i>
                    </div>
                </div>

                <!-- Search Box (Combobox) -->
                <div class="max-w-sm w-full">
                    <input type="hidden" id="category-filter" name="category_id" value="{{ request('category_id') }}">
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

            <!-- Table -->
            @include('admin.notes._table_wrapper')

        @include('admin.notes._modal')

        </div>
@endsection
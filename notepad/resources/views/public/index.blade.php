@extends('layouts.public')

@section('content')
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Title & Search -->
        <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight">
                {{ __('note.views.latest_notes') }}
            </h2>
            <p class="mt-1 text-gray-600">{{ __('note.views.explore_ideas') }}</p>
        </div>

        <!-- Filters -->
        <div class="max-w-4xl mx-auto mb-10">
            <form id="public-filter-form" action="{{ route('public.index') }}" method="GET"
                class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-grow">
                    <input type="text" name="search" id="public-search" value="{{ request('search') }}"
                        class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="{{ __('note.views.search_placeholder') }}">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                        <i data-lucide="search" class="shrink-0 size-4 text-gray-400 dark:text-neutral-500"></i>
                    </div>
                </div>

                <!-- Search Box (Combobox) -->
                <div class="sm:w-48">
                    <input type="hidden" name="category_id" id="public-category" value="{{ request('category_id') }}">
                    <div class="relative" data-hs-combo-box='{
                                "isOpenOnFocus": true
                            }'>
                        <div class="relative">
                            <input
                                class="py-3 px-4 pe-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                type="text" role="combobox" aria-expanded="false"
                                placeholder="{{ __('category.views.all') }}"
                                value="{{ $categories->firstWhere('id', request('category_id')) ? (Lang::has('category.names.' . $categories->firstWhere('id', request('category_id'))->name) ? __('category.names.' . $categories->firstWhere('id', request('category_id'))->name) : $categories->firstWhere('id', request('category_id'))->name) : '' }}"
                                data-hs-combo-box-input="">
                            <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                <i data-lucide="chevron-down" class="shrink-0 size-4 text-gray-500"></i>
                            </div>
                        </div>

                        <!-- Dropdown -->
                        <div class="absolute z-50 w-full bg-white border border-gray-200 rounded-lg shadow-xl p-2 max-h-72 overflow-hidden overflow-y-auto dark:bg-neutral-800 dark:border-neutral-700"
                            style="display: none;" data-hs-combo-box-output="">
                            <div data-hs-combo-box-output-items-wrapper="">
                                <!-- All Option -->
                                <div data-hs-combo-box-output-item tabindex="0">
                                    <span
                                        class="flex items-center cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-200"
                                        data-value="">
                                        <div class="flex items-center w-full">
                                            <div data-hs-combo-box-search-text data-hs-combo-box-value>
                                                {{ __('category.views.all') }}
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <!-- Categories -->
                                @foreach($categories as $category)
                                    @php
                                        $translatedName = Lang::has('category.names.' . $category->name) ? __('category.names.' . $category->name) : $category->name;
                                        $normalizedName = strtolower(\Illuminate\Support\Str::ascii($translatedName));
                                    @endphp
                                    <div data-hs-combo-box-output-item tabindex="0">
                                        <span
                                            class="flex items-center cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-200"
                                            data-value="{{ $category->id }}">
                                            <div class="flex items-center w-full">
                                                <div data-hs-combo-box-search-text="{{ $translatedName }} {{ $normalizedName }}"
                                                    data-hs-combo-box-value>{{ $translatedName }}</div>
                                            </div>
                                            <span class="hidden hs-combo-box-selected:block">
                                                <i data-lucide="check"
                                                    class="shrink-0 size-3.5 text-blue-600 dark:text-blue-500"></i>
                                            </span>
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                @if(request('search') || request('category_id'))
                    <a href="{{ route('public.index') }}"
                        class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
                        <i data-lucide="rotate-ccw" class="shrink-0 size-4"></i>
                        {{ __('note.views.clear') }}
                    </a>
                @endif
            </form>
        </div>
        <!-- End Title & Search -->

        <!-- Grid & Pagination Wrapper -->
        @include('public._notes_wrapper')
        <!-- End Grid & Pagination Wrapper -->
    </div>
@endsection
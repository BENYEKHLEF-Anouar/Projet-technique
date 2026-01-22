@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4 space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('note.views.title') }}</h1>

        <div id="success-msg" class="text-green-600 font-medium h-6"></div>



        <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
            <div class="max-w-sm w-full relative">
                <input type="text" id="search"
                    class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                    placeholder="{{ __('note.views.search_placeholder') }}">
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                    <i data-lucide="search" class="shrink-0 size-4 text-gray-400 dark:text-neutral-500"></i>
                </div>
            </div>

            <div class="max-w-sm w-full">
                <select id="category-filter"
                    class="py-3 px-4 pe-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                    <option value="">{{ __('All Categories') }}</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">
                            {{ trans()->has('category.names.' . $cat->name) ? __('category.names.' . $cat->name) : $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="button" id="openModal"
                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                data-hs-overlay="#hs-slide-down-animation-modal">
                {{ __('note.views.add_note') }}
            </button>
        </div>

        @include('admin.notes._table_wrapper')
    </div>

    @include('admin.notes._modal')
@endsection
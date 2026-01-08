@extends('layouts.app')

@section('content')

    <!-- Hero -->
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-10">
        <div class="text-center max-w-2xl mx-auto">
            <h1 class="block text-3xl font-bold text-gray-800 sm:text-4xl md:text-5xl">
                {!! __('Your Notes, Reimagined') !!}
            </h1>
            <p class="mt-3 text-lg text-gray-800">
                {{ __('Capture your thoughts...') }}
            </p>
        </div>
    </div>
    <!-- End Hero -->

    <!-- Search & Filter -->
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 mb-10">
        <form id="filter-form" action="{{ route('home') }}" method="GET">
            <div class="flex flex-col sm:flex-row gap-y-2 sm:gap-x-4">
                <div class="relative flex-grow">
                    <input type="text" name="search" value="{{ request('search') }}" id="search-input"
                        class="py-3 px-4 ps-11 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="{{ __('Search Notes') }}...">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                    </div>
                </div>

                <div class="sm:w-64">
                    <select name="category" id="category-select"
                        class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <option value="">{{ __('Categories') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <a href="{{ route('home') }}" id="clear-filters"
                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none {{ (!request('search') && !request('category')) ? 'hidden' : '' }}">
                    <i data-lucide="x" class="w-4 h-4"></i>
                    {{ __('Clear all filters') }}
                </a>
            </div>
        </form>
    </div>

    <!-- Notes Grid Container -->
    <div id="notes-container" class="max-w-[85rem] wx-auto px-4 sm:px-6 lg:px-8">
        @include('notes.partials.notes_grid', ['notes' => $notes])
    </div>


@endsection
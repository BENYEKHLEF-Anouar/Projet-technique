@extends('layouts.admin')

@section('header-title', __('Manage Notes'))

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ __('Manage Notes') }}</h2>
            <p class="text-sm text-gray-600 mt-1">{{ __('Create, edit, and delete notes') }}</p>
        </div>
        <button type="button" onclick="openCreateModal()"
            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
            <i data-lucide="plus" class="w-4 h-4"></i>
            {{ __('Create Note') }}
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-white border border-gray-200 rounded-xl p-4 mb-8">
        <form id="filter-form" action="{{ route('admin.notes.index') }}" method="GET"
            class="flex flex-col sm:flex-row gap-4">
            <!-- Search Input -->
            <div class="relative flex-1">
                <input id="search-input" type="text" name="search" value="{{ request('search') }}"
                    placeholder="{{ __('Search notes...') }}"
                    class="py-3 px-4 ps-11 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="sm:w-56">
                <select id="category-select" name="category"
                    class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                    <option value="">{{ __('All Categories') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <!-- Clear Filters -->
            <a id="clear-filters" href="{{ route('admin.notes.index') }}"
                class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none {{ (!request('search') && !request('category')) ? 'hidden' : '' }}">
                <i data-lucide="x" class="w-4 h-4"></i>
            </a>
        </form>
    </div>

    <!-- Notes Table -->
    <div id="notes-container">
        @include('admin.notes._table', ['notes' => $notes])
    </div>

    <!-- Include Modals -->
    @include('admin.notes._modal_form')
    @include('admin.notes._modal_view')

@endsection
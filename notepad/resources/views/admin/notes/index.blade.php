@extends('layouts.admin')

@section('header-title', __('Manage Notes'))

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Manage Notes') }}</h2>
            <p class="text-gray-500 mt-1">{{ __('Create, edit, and delete notes') }}</p>
        </div>
        <button type="button" onclick="openCreateModal()"
            class="inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/40 hover:-translate-y-0.5 active:translate-y-0">
            <i data-lucide="plus" class="w-5 h-5"></i>
            {{ __('Create Note') }}
        </button>
    </div>

    <!-- Filters -->
    <div class="glass p-1.5 rounded-2xl shadow-sm mb-8 border border-gray-200/50">
        <form id="filter-form" action="{{ route('admin.notes.index') }}" method="GET"
            class="flex flex-col sm:flex-row gap-2">
            <!-- Search Input -->
            <div class="relative flex-1 group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <i data-lucide="search"
                        class="w-5 h-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
                </div>
                <input id="search-input" type="text" name="search" value="{{ request('search') }}"
                    placeholder="{{ __('Search notes...') }}"
                    class="w-full pl-11 pr-4 py-3 bg-white border border-transparent rounded-xl text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all placeholder:text-gray-400">
            </div>

            <!-- Category Filter -->
            <div class="sm:w-56">
                <div class="relative h-full">
                    <select id="category-select" name="category"
                        class="w-full h-full px-4 py-3 bg-white border border-transparent rounded-xl text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all cursor-pointer hover:bg-gray-50/50">
                        <option value="">{{ __('All Categories') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <!-- Clear Filters -->
            <a id="clear-filters" href="{{ route('admin.notes.index') }}"
                class="inline-flex items-center justify-center gap-1 px-4 py-3 text-sm font-medium text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all {{ (!request('search') && !request('category')) ? 'hidden' : '' }}">
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
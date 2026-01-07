@extends('layouts.admin')

@section('header-title', 'Manage Notes')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manage Notes</h2>
            <p class="text-gray-600 mt-1">Create, edit, and delete notes</p>
        </div>
        <button type="button" onclick="openCreateModal()"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Create Note
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6">
        <form id="filter-form" action="{{ route('admin.notes.index') }}" method="GET"
            class="flex flex-col sm:flex-row gap-3">
            <!-- Search Input -->
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>
                <input id="search-input" type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search notes..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
            </div>

            <!-- Category Filter -->
            <div class="sm:w-48">
                <select id="category-select" name="category"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <!-- Clear Filters -->
            <a id="clear-filters" href="{{ route('admin.notes.index') }}"
                class="inline-flex items-center gap-1 px-3 py-2 text-sm text-gray-600 hover:text-gray-800 transition {{ (!request('search') && !request('category')) ? 'hidden' : '' }}">
                <i data-lucide="x" class="w-4 h-4"></i>
                Clear
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
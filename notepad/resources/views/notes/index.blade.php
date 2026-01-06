@extends('layouts.app')

@section('content')

   <!-- Search & Filter Section -->
<div class="mb-10 max-w-2xl mx-auto">
    <form id="filter-form" action="{{ route('home') }}" method="GET" class="relative">
        <div class="flex flex-col sm:flex-row gap-3">
            
            <!-- Search Input -->
            <div class="relative w-full">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                   <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       id="search-input"
                       class="py-3 ps-10 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 shadow-sm"
                       placeholder="Search notes...">
            </div>

            <!-- Category Dropdown -->
            <div class="sm:w-64">
                <select name="category" id="category-select"
                        class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 shadow-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <a href="{{ route('home') }}" id="clear-filters" class="inline-flex items-center justify-center gap-x-2 py-3 px-4 rounded-lg border border-transparent text-sm font-semibold text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none transition {{ (!request('search') && !request('category')) ? 'hidden' : '' }}">
                <i data-lucide="x" class="w-4 h-4"></i>
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Notes Grid Container (to be updated via AJAX) -->
<div id="notes-container">
    @include('notes.partials.notes_grid', ['notes' => $notes])
</div>


@endsection
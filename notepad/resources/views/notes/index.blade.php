@extends('layouts.app')

@section('content')

    <!-- Search & Filter Section -->
    <div class="mb-10 max-w-2xl mx-auto">
        <form action="{{ route('home') }}" method="GET" class="relative">
            <div class="flex flex-col sm:flex-row gap-3">
                
                <!-- Search Input -->
                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                       <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="py-3 ps-10 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 shadow-sm"
                           placeholder="Search notes...">
                </div>

                <!-- Category Dropdown -->
                <div class="sm:w-64">
                    <select name="category" onchange="this.form.submit()"
                            class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 shadow-sm">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if(request('search') || request('category'))
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-x-2 py-3 px-4 rounded-lg border border-transparent text-sm font-semibold text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none transition">
                        <i data-lucide="x" class="w-4 h-4"></i>
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Notes Grid -->
    @if($notes->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($notes as $note)
                <div class="flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-lg transition dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 h-full overflow-hidden">
                    <a href="{{ route('notes.show', $note->id) }}" class="flex-1 flex flex-col group">
                        @if($note->image)
                            <div class="h-48 overflow-hidden relative">
                                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
                                     src="{{ asset('storage/' . $note->image) }}" 
                                     alt="{{ $note->name }}">
                            </div>
                        @else
                            <div class="h-48 bg-gray-100 flex items-center justify-center dark:bg-neutral-800">
                                <i data-lucide="image-off" class="w-10 h-10 text-gray-400"></i>
                            </div>
                        @endif

                        <div class="p-4 md:p-5 flex-1 flex flex-col">
                            <!-- Categories Badge -->
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach($note->categories as $cat)
                                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-800/30 dark:text-indigo-500">
                                        {{ $cat->name }}
                                    </span>
                                @endforeach
                            </div>

                            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2 group-hover:text-indigo-600 transition">
                                {{ $note->name }}
                            </h3>
                            
                            <p class="mt-1 text-gray-500 dark:text-neutral-400 line-clamp-3 mb-4 flex-1">
                                {{ $note->content }}
                            </p>
                        </div>
                    </a>
                    
                    <div class="mt-auto px-4 md:px-5 py-4 border-t border-gray-100 dark:border-neutral-700 flex items-center justify-between text-xs text-gray-400">
                        <span class="flex items-center gap-1">
                            <i data-lucide="calendar" class="w-3 h-3"></i>
                            {{ $note->created_at->format('M d, Y') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i data-lucide="user" class="w-3 h-3"></i>
                            {{ $note->user->name ?? 'Unknown' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10 py-4 flex justify-center">
             {{ $notes->onEachSide(1)->links('pagination::tailwind') }}
        </div>
    @else
        <div class="text-center py-20">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-6">
                <i data-lucide="search-x" class="w-8 h-8 text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900">No notes found</h3>
            <p class="text-gray-500 mt-2">Try adjusting your search or category filter.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-indigo-600 hover:text-indigo-800 disabled:opacity-50 disabled:pointer-events-none dark:text-indigo-500 dark:hover:text-indigo-400 transition">
                Clear all filters
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    @endif

@endsection
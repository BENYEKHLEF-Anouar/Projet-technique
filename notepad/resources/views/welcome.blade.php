@extends('layouts.guest')

@section('content')
    <div class="flex flex-col gap-10">
        <!-- Hero / Search Section -->
        <div class="relative overflow-hidden">
            <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-20">
                <div class="text-center">
                    <h1 class="text-4xl sm:text-6xl font-bold text-gray-800 dark:text-gray-200 tracking-tight">
                        {{ __('Explore') }} <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-violet-600">{{ __('Notes') }}</span>
                    </h1>
                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        {{ __('Your central hub for capturing ideas, organizing thoughts, and accessing them anywhere.') }}
                    </p>

        <!-- Search & Filter Controls -->
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 relative z-20">
             <div class="bg-white border border-gray-200 shadow-lg rounded-full p-1.5 dark:bg-slate-900 dark:border-gray-700">
                <div class="flex flex-col md:flex-row items-center gap-1">
                     <!-- Search Input -->
                    <div class="relative flex-grow w-full md:w-auto group">
                        <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                            <svg class="flex-shrink-0 size-4 text-gray-400 group-focus-within:text-blue-600 transition-colors" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        </div>
                        <input type="text" id="search-input" name="search" 
                            class="py-3 px-4 ps-11 block w-full bg-transparent border-none rounded-full text-sm font-medium text-gray-800 placeholder-gray-400 focus:ring-0 focus:bg-gray-50 dark:text-gray-200 dark:focus:bg-slate-800 transition-all" 
                            placeholder="{{ __('Search...') }}" 
                            value="{{ request('search') }}">
                    </div>

                    <div class="hidden md:block w-px h-6 bg-gray-200 dark:bg-gray-700 mx-2"></div>

                    <!-- Category Filter -->
                    <div class="relative w-full md:w-48 group border-t md:border-t-0 border-gray-100 dark:border-gray-700 md:border-l-0">
                         <select id="category-select" class="py-3 px-4 ps-4 pe-9 block w-full bg-transparent border-none rounded-full text-sm font-medium text-gray-800 focus:ring-0 focus:bg-gray-50 dark:text-gray-200 dark:focus:bg-slate-800 cursor-pointer transition-all">
                            <option value="">{{ __('All Categories') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                         </select>
                    </div>
                </div>
             </div>
        </div>
        <!-- End Search & Filter Controls -->

        <!-- Card Grid -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto w-full">
            <!-- Grid -->
            <div id="notes-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @include('partials.notes-grid')
            </div>
            <!-- End Grid -->
        </div>
        <!-- End Card Grid -->
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search-input');
        const categorySelect = document.getElementById('category-select');
        const notesGrid = document.getElementById('notes-grid');

        let timeout = null;

        function fetchNotes() {
            const search = searchInput.value;
            const category = categorySelect.value;
            
            const url = new URL(window.location.href);
            if (search) url.searchParams.set('search', search); else url.searchParams.delete('search');
            if (category) url.searchParams.set('category', category); else url.searchParams.delete('category');
            
            // Push state to URL so refresh works
            window.history.pushState({}, '', url);

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                notesGrid.innerHTML = html;
            })
            .catch(error => console.error('Error:', error));
        }

        if (searchInput) {
            searchInput.addEventListener('input', () => {
                clearTimeout(timeout);
                timeout = setTimeout(fetchNotes, 300); // Debounce
            });
        }

        if (categorySelect) {
            categorySelect.addEventListener('change', () => {
                 fetchNotes();
            });
        }
    });
</script>
@endpush
@endsection
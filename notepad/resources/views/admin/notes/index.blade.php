@extends('layouts.admin')

@section('header-title', 'Manage Notes')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manage Notes</h2>
            <p class="text-gray-600 mt-1">Create, edit, and delete notes</p>
        </div>
        <a href="{{ route('admin.notes.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Create Note
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6">
        <form id="filter-form" action="{{ route('admin.notes.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <!-- Search Input -->
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>
                <input id="search-input" type="text" name="search" value="{{ request('search') }}" placeholder="Search notes..."
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
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Categories</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($notes as $note)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($note->image)
                                            <img src="{{ asset('storage/' . $note->image) }}" alt="{{ $note->name }}"
                                                class="w-12 h-12 rounded-lg object-cover">
                                        @else
                                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <i data-lucide="file-text" class="w-5 h-5 text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($note->name, 40) }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($note->categories as $cat)
                                            <span
                                                class="px-2 py-0.5 text-xs rounded-full bg-indigo-50 text-indigo-600 border border-indigo-100">
                                                {{ $cat->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600">{{ $note->user->name ?? 'Unknown' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600">{{ $note->created_at->format('M d, Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('notes.show', $note->id) }}" target="_blank"
                                            class="p-2 text-gray-400 hover:text-indigo-600 transition" title="View">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                        <a href="{{ route('admin.notes.edit', $note->id) }}"
                                            class="p-2 text-gray-400 hover:text-indigo-600 transition" title="Edit">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.notes.destroy', $note->id) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this note?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition"
                                                title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                        <i data-lucide="inbox" class="w-8 h-8 text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-600">No notes found</p>
                                    <p class="text-sm text-gray-500 mt-1">Try adjusting your filters or create a new note</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($notes->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 pagination-container">
                    {{ $notes->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </div>

@push('scripts')
    <script type="module">
        import { initFilters } from '/notepad/resources/js/filters.js';
        initFilters();
    </script>
@endpush
@endsection
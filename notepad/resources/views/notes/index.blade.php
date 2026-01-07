@extends('layouts.app')

@section('content')

    <!-- Hero Section -->
    <div class="text-center mb-16 animate-fade-in">
        <div
            class="inline-block p-1 px-3 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-xs font-semibold uppercase tracking-wide mb-4 shadow-sm">
            Vos idées, sécurisées
        </div>
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 tracking-tight">
            Vos Notes, <span
                class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-600">Réinventées</span>
        </h1>
        <p class="text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed">
            Capturez vos pensées, organisez vos projets et boostez votre productivité avec une interface simple et élégante.
        </p>
    </div>

    <!-- Search & Filter Section -->
    <div class="mb-12 max-w-3xl mx-auto animate-slide-up" style="animation-delay: 0.1s;">
        <form id="filter-form" action="{{ route('home') }}" method="GET" class="relative z-10">
            <div
                class="glass p-2 rounded-2xl shadow-xl shadow-indigo-100/50 border border-white/50 flex flex-col sm:flex-row gap-2">

                <!-- Search Input -->
                <div class="relative flex-grow group">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                        <i data-lucide="search"
                            class="w-5 h-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" id="search-input"
                        class="py-3.5 ps-11 block w-full bg-white/50 border-transparent rounded-xl text-base focus:border-indigo-500 focus:ring-0 focus:bg-white transition-all placeholder:text-gray-400 text-gray-800"
                        placeholder="Rechercher des notes...">
                </div>

                <!-- Category Dropdown -->
                <div class="sm:w-64">
                    <div class="relative h-full">
                        <select name="category" id="category-select"
                            class="py-3.5 px-4 pe-9 block w-full h-full bg-gray-50/50 border-transparent rounded-xl text-sm font-medium focus:border-indigo-500 focus:ring-0 focus:bg-white transition-all cursor-pointer hover:bg-gray-50">
                            <option value="">Toutes les Catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <a href="{{ route('home') }}" id="clear-filters"
                    class="inline-flex items-center justify-center gap-x-2 px-5 py-3.5 rounded-xl border border-transparent text-sm font-semibold text-gray-500 hover:text-red-500 hover:bg-red-50 transition-all {{ (!request('search') && !request('category')) ? 'hidden' : '' }}">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Notes Grid Container (to be updated via AJAX) -->
    <div id="notes-container">
        @include('notes.partials.notes_grid', ['notes' => $notes])
    </div>


@endsection
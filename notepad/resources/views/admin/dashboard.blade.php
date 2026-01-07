@extends('layouts.admin')

@section('header-title', __('Dashboard'))

@section('content')
    <div class="mb-8 animate-fade-in">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Welcome to the Admin Panel') }}</h2>
        <p class="text-gray-500 mt-2 text-lg">{{ __('Manage your notes and categories from here') }}</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10 animate-slide-up" style="animation-delay: 0.1s;">
        <!-- Total Notes -->
        <div
            class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl shadow-lg shadow-indigo-200">
                    <i data-lucide="notebook" class="w-8 h-8 text-white"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Total Notes') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\Note::count() }}</p>
                </div>
            </div>
        </div>

        <!-- Total Categories -->
        <div
            class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-gradient-to-br from-purple-500 to-fuchsia-600 rounded-xl shadow-lg shadow-purple-200">
                    <i data-lucide="tags" class="w-8 h-8 text-white"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Total Categories') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\Category::count() }}</p>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div
            class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-gradient-to-br from-orange-400 to-red-500 rounded-xl shadow-lg shadow-orange-200">
                    <i data-lucide="users" class="w-8 h-8 text-white"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Total Users') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\User::count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8 animate-slide-up" style="animation-delay: 0.2s;">
        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
            <i data-lucide="zap" class="w-5 h-5 text-yellow-500"></i> {{ __('Quick Actions') }}
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Create New Note -->
            <a href="{{ route('admin.notes.create') }}"
                class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-between">
                <div>
                    <div
                        class="p-3 bg-blue-50 text-blue-600 rounded-xl w-fit mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="file-plus" class="w-6 h-6"></i>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                        {{ __('Create Note') }}
                    </h4>
                    <p class="text-sm text-gray-500 mt-1 group-hover:text-gray-600">{{ __('Add a new note') }}</p>
                </div>
                <div
                    class="p-2 bg-gray-50 rounded-full text-gray-400 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </div>
            </a>

            <!-- View All Notes -->
            <a href="{{ route('admin.notes.index') }}"
                class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-between">
                <div>
                    <div
                        class="p-3 bg-indigo-50 text-indigo-600 rounded-xl w-fit mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="notebook" class="w-6 h-6"></i>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">
                        {{ __('All Notes') }}</h4>
                    <p class="text-sm text-gray-500 mt-1 group-hover:text-gray-600">{{ __('Manage your collection') }}</p>
                </div>
                <div
                    class="p-2 bg-gray-50 rounded-full text-gray-400 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </div>
            </a>

            <!-- Search Notes -->
            <a href="{{ route('admin.notes.index') }}"
                class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-between">
                <div>
                    <div
                        class="p-3 bg-purple-50 text-purple-600 rounded-xl w-fit mb-4 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                        <i data-lucide="search" class="w-6 h-6"></i>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-purple-600 transition-colors">Rechercher
                    </h4>
                    <p class="text-sm text-gray-500 mt-1 group-hover:text-gray-600">Trouver une note</p>
                </div>
                <div
                    class="p-2 bg-gray-50 rounded-full text-gray-400 group-hover:bg-purple-50 group-hover:text-purple-600 transition-colors">
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </div>
            </a>
        </div>
    </div>
@endsection
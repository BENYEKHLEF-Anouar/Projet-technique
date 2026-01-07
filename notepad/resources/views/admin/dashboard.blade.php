@extends('layouts.admin')

@section('header-title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Welcome to Admin Panel</h2>
        <p class="text-gray-600 mt-1">Manage your notes and categories from here</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Notes -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-50 rounded-lg">
                    <i data-lucide="notebook" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Notes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Note::count() }}</p>
                </div>
            </div>
        </div>

        <!-- Total Categories -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-purple-50 rounded-lg">
                    <i data-lucide="tags" class="w-6 h-6 text-purple-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Categories</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Category::count() }}</p>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-orange-50 rounded-lg">
                    <i data-lucide="users" class="w-6 h-6 text-orange-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Create New Note -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex flex-col h-full">
                    <div class="p-3 bg-blue-50 rounded-lg w-fit mb-4">
                        <i data-lucide="file-plus" class="w-6 h-6 text-blue-600"></i>
                    </div>
                    <h4 class="text-base font-semibold text-gray-900 mb-2">Create Note</h4>
                    <p class="text-sm text-gray-600 mb-4 flex-grow">Add a new note to your collection</p>
                    <a href="{{ route('admin.notes.create') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                        Create Now
                    </a>
                </div>
            </div>

            <!-- View All Notes -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex flex-col h-full">
                    <div class="p-3 bg-indigo-50 rounded-lg w-fit mb-4">
                        <i data-lucide="notebook" class="w-6 h-6 text-indigo-600"></i>
                    </div>
                    <h4 class="text-base font-semibold text-gray-900 mb-2">All Notes</h4>
                    <p class="text-sm text-gray-600 mb-4 flex-grow">View and manage all your notes</p>
                    <a href="{{ route('admin.notes.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                        View Notes
                    </a>
                </div>
            </div>

            <!-- Search Notes -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex flex-col h-full">
                    <div class="p-3 bg-purple-50 rounded-lg w-fit mb-4">
                        <i data-lucide="search" class="w-6 h-6 text-purple-600"></i>
                    </div>
                    <h4 class="text-base font-semibold text-gray-900 mb-2">Search Notes</h4>
                    <p class="text-sm text-gray-600 mb-4 flex-grow">Find notes quickly by keyword</p>
                    <a href="{{ route('admin.notes.index') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition">
                        Search
                    </a>
                </div>
            </div>

            <!-- View Statistics -->
            <!-- <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex flex-col h-full">
                    <div class="p-3 bg-orange-50 rounded-lg w-fit mb-4">
                        <i data-lucide="bar-chart-3" class="w-6 h-6 text-orange-600"></i>
                    </div>
                    <h4 class="text-base font-semibold text-gray-900 mb-2">Statistics</h4>
                    <p class="text-sm text-gray-600 mb-4 flex-grow">View detailed statistics and insights</p>
                    <a href="{{ route('admin.notes.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition">
                        View Stats
                    </a>
                </div>
            </div> -->
        </div>
    </div>
@endsection
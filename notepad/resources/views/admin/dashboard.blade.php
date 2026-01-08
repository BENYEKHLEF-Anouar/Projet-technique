@extends('layouts.admin')

@section('header-title', __('Dashboard'))

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">{{ __('Welcome to the Admin Panel') }}</h2>
        <p class="text-sm text-gray-600">{{ __('Manage your notes and categories from here') }}</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        <!-- Total Notes -->
        <div class="flex flex-col bg-white border shadow-sm rounded-xl">
            <div class="p-4 md:p-5 flex gap-x-4">
                <div class="flex-shrink-0 flex justify-center items-center w-[46px] h-[46px] bg-gray-100 rounded-lg">
                    <i data-lucide="notebook" class="flex-shrink-0 w-5 h-5 text-gray-600"></i>
                </div>
                <div class="grow">
                    <div class="flex items-center gap-x-2">
                        <p class="text-xs uppercase tracking-wide text-gray-500">
                            {{ __('Total Notes') }}
                        </p>
                    </div>
                    <div class="mt-1 flex items-center gap-x-2">
                        <h3 class="text-xl sm:text-2xl font-medium text-gray-800">
                            {{ \App\Models\Note::count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Categories -->
        <div class="flex flex-col bg-white border shadow-sm rounded-xl">
            <div class="p-4 md:p-5 flex gap-x-4">
                <div class="flex-shrink-0 flex justify-center items-center w-[46px] h-[46px] bg-gray-100 rounded-lg">
                    <i data-lucide="tags" class="flex-shrink-0 w-5 h-5 text-gray-600"></i>
                </div>
                <div class="grow">
                    <div class="flex items-center gap-x-2">
                        <p class="text-xs uppercase tracking-wide text-gray-500">
                            {{ __('Total Categories') }}
                        </p>
                    </div>
                    <div class="mt-1 flex items-center gap-x-2">
                        <h3 class="text-xl sm:text-2xl font-medium text-gray-800">
                            {{ \App\Models\Category::count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="flex flex-col bg-white border shadow-sm rounded-xl">
            <div class="p-4 md:p-5 flex gap-x-4">
                <div class="flex-shrink-0 flex justify-center items-center w-[46px] h-[46px] bg-gray-100 rounded-lg">
                    <i data-lucide="users" class="flex-shrink-0 w-5 h-5 text-gray-600"></i>
                </div>
                <div class="grow">
                    <div class="flex items-center gap-x-2">
                        <p class="text-xs uppercase tracking-wide text-gray-500">
                            {{ __('Total Users') }}
                        </p>
                    </div>
                    <div class="mt-1 flex items-center gap-x-2">
                        <h3 class="text-xl sm:text-2xl font-medium text-gray-800">
                            {{ \App\Models\User::count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            {{ __('Quick Actions') }}
        </h3>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
            <!-- Create New Note -->
            <a href="{{ route('admin.notes.create') }}"
                class="group flex flex-col pt-6 pb-4 px-4 text-center bg-white border shadow-sm rounded-xl hover:shadow-md transition">
                <div class="mx-auto flex justify-center items-center w-12 h-12 bg-blue-50 rounded-full mb-3">
                    <i data-lucide="file-plus" class="flex-shrink-0 w-6 h-6 text-blue-600"></i>
                </div>
                <h3 class="group-hover:text-blue-600 font-semibold text-gray-800">
                    {{ __('Create Note') }}
                </h3>
                <p class="text-sm text-gray-500">
                    {{ __('Add a new note') }}
                </p>
            </a>

            <!-- View All Notes -->
            <a href="{{ route('admin.notes.index') }}"
                class="group flex flex-col pt-6 pb-4 px-4 text-center bg-white border shadow-sm rounded-xl hover:shadow-md transition">
                <div class="mx-auto flex justify-center items-center w-12 h-12 bg-gray-100 rounded-full mb-3">
                    <i data-lucide="notebook" class="flex-shrink-0 w-6 h-6 text-gray-600"></i>
                </div>
                <h3 class="group-hover:text-blue-600 font-semibold text-gray-800">
                    {{ __('All Notes') }}
                </h3>
                <p class="text-sm text-gray-500">
                    {{ __('Manage your collection') }}
                </p>
            </a>
        </div>
    </div>
@endsection
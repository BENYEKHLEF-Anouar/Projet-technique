@extends('layouts.public')

@section('content')
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Title & Search -->
        <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight">
                {{ __('note.views.latest_notes') ?? 'Latest Notes' }}
            </h2>
            <p class="mt-1 text-gray-600">{{ __('note.views.explore_ideas') ?? 'Explore ideas and creativity.' }}</p>
        </div>

        <!-- Filters -->
        <div class="max-w-4xl mx-auto mb-10">
            <form id="public-filter-form" action="{{ route('public.index') }}" method="GET"
                class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-grow">
                    <input type="text" name="search" id="public-search" value="{{ request('search') }}"
                        class="py-3 px-4 ps-11 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="{{ __('note.views.search_placeholder') ?? 'Search notes...' }}">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                    </div>
                </div>

                <select name="category_id" id="public-category"
                    class="py-3 px-4 pe-9 block w-full sm:w-48 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">{{ __('category.views.all') ?? 'All Categories' }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ trans()->has('category.names.' . $category->name) ? __('category.names.' . $category->name) : $category->name }}
                        </option>
                    @endforeach
                </select>

                @if(request('search') || request('category_id'))
                    <a href="{{ route('public.index') }}"
                        class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        Clear
                    </a>
                @endif
            </form>
        </div>
        <!-- End Title & Search -->

        <!-- Grid & Pagination Wrapper -->
        @include('public._notes_wrapper')
        <!-- End Grid & Pagination Wrapper -->
    </div>
@endsection
@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4 space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('note.views.title') }}</h1>

        <div id="success-msg" class="text-green-600 font-medium h-6"></div>



        <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
            <div class="max-w-sm w-full">
                <input type="text" id="search"
                    class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                    placeholder="{{ __('note.views.search_placeholder') }}">
            </div>
            
            <div class="max-w-sm w-full">
                 <select id="category-filter" class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                    <option value="">{{ __('All Categories') }}</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name ?? $cat->nom }}</option>
                    @endforeach
                 </select>
            </div>

            <button type="button" id="openModal"
                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                data-hs-overlay="#hs-slide-down-animation-modal">
                {{ __('note.views.add_note') }}
            </button>
        </div>

        @include('admin.notes._table_wrapper')
    </div>

    @include('admin.notes._modal')
@endsection
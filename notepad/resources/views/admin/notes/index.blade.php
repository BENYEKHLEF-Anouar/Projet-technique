@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('note.views.title') }}</h1>

        <div id="success-msg" class="text-green-600 font-medium h-6">
            {{ session('success') }}
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
            <div class="max-w-sm w-full">
                <input type="text" id="search"
                    class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                    placeholder="{{ __('note.views.search_placeholder') }}">
            </div>

            <button type="button" id="openModal"
                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                data-hs-overlay="#hs-slide-down-animation-modal">
                {{ __('note.views.add_note') }}
            </button>
        </div>

        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div
                        class="border border-gray-200 rounded-lg shadow-xs overflow-hidden dark:border-neutral-700 dark:shadow-gray-900">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <thead class="bg-gray-50 dark:bg-neutral-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        {{ __('note.attributes.name') }}</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        {{ __('note.attributes.content') }}</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        {{ __('note.attributes.categories') }}</th>
                                </tr>
                            </thead>
                            <tbody id="notes-table" class="divide-y divide-gray-200 dark:divide-neutral-700">
                                @include('admin.notes._table_body')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.notes._modal')
@endsection
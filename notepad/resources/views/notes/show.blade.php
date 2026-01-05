@extends('layouts.guest')

@section('content')
    <div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="mb-8">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-x-1.5 text-sm text-gray-600 decoration-2 hover:underline hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-400 font-medium">
                <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                Back to Home
            </a>
        </div>

        <!-- Note Content -->
        <div
            class="bg-white border border-gray-200 shadow-xl shadow-gray-200/40 rounded-3xl overflow-hidden dark:bg-slate-900 dark:border-gray-700 dark:shadow-slate-700/[.7]">

            @if($note->image_url)
                <div class="relative h-64 sm:h-96 w-full">
                    <img class="w-full h-full object-cover" src="{{ $note->image_url }}" alt="{{ $note->name }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                </div>
            @endif

            <div class="p-6 sm:p-10">
                <div class="space-y-5">
                    <div class="space-y-3">
                        <h1 class="text-3xl font-bold md:text-5xl dark:text-white leading-tight">
                            {{ $note->name }}
                        </h1>

                        <div class="flex flex-wrap items-center gap-2">
                            @foreach($note->categories as $category)
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>

                        <!-- Author & Date -->
                        <div class="flex items-center gap-x-3 mt-4">
                            <img class="size-10 rounded-full object-cover ring-2 ring-white dark:ring-gray-800"
                                src="https://ui-avatars.com/api/?name={{ urlencode($note->user->name) }}&background=EBF4FF&color=7F9CF5"
                                alt="{{ $note->user->name }}">
                            <div>
                                <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                                    {{ $note->user->name }}
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Published on {{ $note->created_at->format('F j, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="py-6 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-lg text-gray-800 dark:text-gray-200 whitespace-pre-wrap leading-relaxed">
                            {!! nl2br(e($note->content)) !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Note Content -->
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-10">
        <!-- Breadcrumbs -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <div class="flex items-center">
                        <a href="{{ route('home') }}"
                            class="text-sm font-medium text-gray-500 hover:text-indigo-600 transition flex items-center gap-1">
                            <i data-lucide="home" class="w-4 h-4"></i>
                            Home
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                        <span class="ms-2 text-sm font-medium text-gray-400 cursor-default">Note Detail</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Note Content -->
        <article class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
            @if($note->image)
                <div class="w-full aspect-video overflow-hidden">
                    <img src="{{ asset('storage/' . $note->image) }}" alt="{{ $note->name }}"
                        class="w-full h-full object-cover">
                </div>
            @endif

            <div class="p-6 sm:p-10">
                <!-- Categories -->
                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach($note->categories as $category)
                        <span
                            class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            {{ $category->name }}
                        </span>
                    @endforeach
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $note->name }}</h1>

                <div class="flex items-center gap-4 text-sm text-gray-500 mb-8 border-b border-gray-100 pb-6">
                    <div class="flex items-center gap-1">
                        <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                        <span>{{ $note->user->name ?? 'Unknown' }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                        <span>{{ $note->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $note->content }}
                </div>
            </div>
        </article>

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-x-2 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to Home
            </a>
        </div>
    </div>
@endsection
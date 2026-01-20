@extends('layouts.public')

@section('content')
    <div class="max-w-3xl px-4 pt-6 lg:pt-10 pb-12 sm:px-6 lg:px-8 mx-auto">
        <div class="max-w-2xl">
            <!-- Back Button -->
            <a class="inline-flex items-center gap-x-1.5 text-sm text-gray-600 decoration-2 hover:underline hover:text-blue-600 mb-6"
                href="{{ route('public.index') }}">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                {{ __('note.views.back_to_notes') ?? 'Back to Notes' }}
            </a>

            <!-- Content -->
            <div class="space-y-5 md:space-y-8">
                <div class="space-y-3">
                    <h1 class="text-3xl font-bold md:text-4xl md:leading-tight dark:text-white">{{ $note->name }}</h1>
                    <div class="flex items-center gap-x-2 text-sm text-gray-500">
                        <div class="flex items-center gap-x-1.5">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            <span>{{ $note->created_at->format('F d, Y') }}</span>
                        </div>
                        <span>•</span>
                        <div class="flex items-center gap-x-1.5">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span>{{ $note->user->name ?? 'Unknown' }}</span>
                        </div>
                        <span>•</span>
                        <div class="flex flex-wrap gap-1">
                            @foreach($note->categories as $cat)
                                <span
                                    class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ trans()->has('category.names.' . $cat->name) ? __('category.names.' . $cat->name) : $cat->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                @if($note->image)
                    <figure>
                        <img class="w-full object-cover rounded-xl shadow-lg" src="{{ asset('storage/' . $note->image) }}"
                            alt="{{ $note->name }}">
                    </figure>
                @endif

                <div class="text-lg text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-line">
                    {{ $note->content }}
                </div>
            </div>
            <!-- End Content -->
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- Back Link -->
        <a class="inline-flex items-center gap-x-1.5 text-sm text-gray-600 decoration-2 hover:underline hover:text-blue-600 mb-6" href="{{ route('home') }}">
            <i data-lucide="chevron-left" class="w-4 h-4"></i>
            {{ __('Back to Home') }}
        </a>

        <!-- Content -->
        <div class="space-y-5 md:space-y-8">
            <div class="space-y-3">
                <h2 class="text-2xl font-bold md:text-3xl dark:text-white">{{ $note->name }}</h2>

                <div class="flex items-center gap-x-2">
                    <div class="flex items-center gap-x-2">
                        <div class="flex-shrink-0">
                             <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 border border-gray-200 text-xs font-medium text-gray-600">
                                {{ substr($note->user->name ?? '?', 0, 1) }}
                            </div>
                        </div>
                        <div class="grow">
                             <p class="text-sm font-semibold text-gray-800">
                                {{ $note->user->name ?? __('Unknown') }}
                            </p>
                        </div>
                    </div>
                     <span class="text-xs text-gray-400">&bull;</span>
                    <p class="text-xs text-gray-500">
                        {{ $note->created_at->format('M d, Y') }}
                    </p>
                </div>
            </div>

            @if($note->image)
                <figure>
                    <img class="w-full object-cover rounded-xl" src="{{ asset('storage/' . $note->image) }}" alt="{{ $note->name }}">
                </figure>
            @endif

            <p class="text-lg text-gray-800">
                {{ $note->content }}
            </p>

            <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-200">
                @foreach($note->categories as $cat)
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        {{ $cat->name }}
                    </span>
                @endforeach
            </div>
        </div>
        <!-- End Content -->
    </div>
@endsection
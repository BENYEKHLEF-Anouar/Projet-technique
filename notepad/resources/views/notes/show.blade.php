@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6 animate-fade-in">
        <!-- Breadcrumbs -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol
                class="flex items-center space-x-2 bg-white/50 backdrop-blur-sm px-4 py-2 rounded-full border border-white/60 shadow-sm">
                <li>
                    <div class="flex items-center">
                        <a href="{{ route('home') }}"
                            class="text-sm font-medium text-gray-500 hover:text-indigo-600 transition flex items-center gap-1.5">
                            <i data-lucide="home" class="w-4 h-4"></i>
                            Accueil
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                        <span class="ms-2 text-sm font-medium text-gray-400 cursor-default">Détail de la Note</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Note Content -->
        <article class="glass rounded-2xl overflow-hidden shadow-xl shadow-indigo-100/20 border border-white/60">
            @if($note->image)
                <div class="w-full h-80 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent z-10"></div>
                    <img src="{{ asset('storage/' . $note->image) }}" alt="{{ $note->name }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                </div>
            @endif

            <div class="p-8 sm:p-12 relative">
                <!-- Categories -->
                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach($note->categories as $category)
                        <span
                            class="inline-flex items-center py-1.5 px-3 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100/50 uppercase tracking-wide">
                            {{ $category->name }}
                        </span>
                    @endforeach
                </div>

                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6 tracking-tight leading-tight">{{ $note->name }}
                </h1>

                <div class="flex items-center gap-6 text-sm text-gray-500 mb-10 border-b border-gray-100/80 pb-8">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-indigo-50 rounded-full text-indigo-600">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </div>
                        <span class="font-medium">{{ $note->user->name ?? 'Inconnu' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-violet-50 rounded-full text-violet-600">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </div>
                        <span class="font-medium">{{ $note->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                <div class="prose prose-lg prose-indigo max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $note->content }}
                </div>
            </div>
        </article>

        <div class="mt-10 text-center">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-x-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition-all hover:-translate-x-1">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Retour à l'Accueil
            </a>
        </div>
    </div>
@endsection
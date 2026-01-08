@if($notes->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 animate-slide-up" style="animation-delay: 0.2s;">
        @foreach($notes as $note)
            <div class="group flex flex-col glass rounded-2xl overflow-hidden card-hover h-full border border-white/60">
                <a href="{{ route('notes.show', $note->id) }}" class="flex-1 flex flex-col">
                    @if($note->image)
                        <div class="h-52 overflow-hidden relative">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors z-10"></div>
                            <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                src="{{ asset('storage/' . $note->image) }}" alt="{{ $note->name }}">
                        </div>
                    @else
                        <div
                            class="h-52 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center group-hover:from-indigo-50/50 group-hover:to-violet-50/50 transition-colors">
                            <div
                                class="p-4 rounded-full bg-white shadow-sm text-gray-300 group-hover:text-indigo-300 group-hover:scale-110 transition-all duration-300">
                                <i data-lucide="image-off" class="w-8 h-8"></i>
                            </div>
                        </div>
                    @endif

                    <div class="p-5 flex-1 flex flex-col">
                        <!-- Categories Badge -->
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($note->categories as $cat)
                                <span
                                    class="inline-flex items-center py-1 px-2.5 rounded-lg text-xs font-medium bg-indigo-50/80 text-indigo-700 border border-indigo-100/50">
                                    {{ $cat->name }}
                                </span>
                            @endforeach
                        </div>

                        <h3
                            class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors tracking-tight">
                            {{ $note->name }}
                        </h3>

                        <p class="mt-1 text-gray-500 text-sm line-clamp-3 leading-relaxed mb-4 flex-1">
                            {{ $note->content }}
                        </p>
                    </div>
                </a>

                <div
                    class="mt-auto px-5 py-4 border-t border-gray-100/60 bg-gray-50/30 flex items-center justify-between text-xs font-medium text-gray-400">
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        {{ $note->created_at->format('M d, Y') }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="user" class="w-3.5 h-3.5"></i>
                        {{ $note->user->name ?? __('Unknown') }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-10 py-4 flex justify-center pagination-container">
        {{ $notes->onEachSide(1)->links('pagination::tailwind') }}
    </div>
@else
    <div class="text-center py-20">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-6">
            <i data-lucide="search-x" class="w-8 h-8 text-gray-400"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900">{{ __('No notes found') }}</h3>
        <p class="text-gray-500 mt-2">{{ __('Try adjusting your search or category filter.') }}</p>
        <a href="{{ route('home') }}"
            class="mt-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-indigo-600 hover:text-indigo-800 disabled:opacity-50 disabled:pointer-events-none dark:text-indigo-500 dark:hover:text-indigo-400 transition">
            {{ __('Clear all filters') }}
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
@endif
@if($notes->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($notes as $note)
            <div
                class="flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-lg transition dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 h-full overflow-hidden">
                <a href="{{ route('notes.show', $note->id) }}" class="flex-1 flex flex-col group">
                    @if($note->image)
                        <div class="h-48 overflow-hidden relative">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                src="{{ asset('storage/' . $note->image) }}" alt="{{ $note->name }}">
                        </div>
                    @else
                        <div class="h-48 bg-gray-100 flex items-center justify-center dark:bg-neutral-800">
                            <i data-lucide="image-off" class="w-10 h-10 text-gray-400"></i>
                        </div>
                    @endif

                    <div class="p-4 md:p-5 flex-1 flex flex-col">
                        <!-- Categories Badge -->
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($note->categories as $cat)
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-800/30 dark:text-indigo-500">
                                    {{ $cat->name }}
                                </span>
                            @endforeach
                        </div>

                        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2 group-hover:text-indigo-600 transition">
                            {{ $note->name }}
                        </h3>

                        <p class="mt-1 text-gray-500 dark:text-neutral-400 line-clamp-3 mb-4 flex-1">
                            {{ $note->content }}
                        </p>
                    </div>
                </a>

                <div
                    class="mt-auto px-4 md:px-5 py-4 border-t border-gray-100 dark:border-neutral-700 flex items-center justify-between text-xs text-gray-400">
                    <span class="flex items-center gap-1">
                        <i data-lucide="calendar" class="w-3 h-3"></i>
                        {{ $note->created_at->format('M d, Y') }}
                    </span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="user" class="w-3 h-3"></i>
                        {{ $note->user->name ?? 'Unknown' }}
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
        <h3 class="text-lg font-medium text-gray-900">Aucune note trouvée</h3>
        <p class="text-gray-500 mt-2">Essayez d'ajuster votre recherche ou filtre par catégorie.</p>
        <a href="{{ route('home') }}"
            class="mt-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-indigo-600 hover:text-indigo-800 disabled:opacity-50 disabled:pointer-events-none dark:text-indigo-500 dark:hover:text-indigo-400 transition">
            Effacer tous les filtres
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
@endif
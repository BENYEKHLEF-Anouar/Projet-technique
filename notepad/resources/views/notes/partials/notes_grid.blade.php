@if($notes->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($notes as $note)
            <div
                class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition">
                <a href="{{ route('notes.show', $note->id) }}" class="flex-1 flex flex-col">
                    @if($note->image)
                        <div class="h-52 overflow-hidden rounded-t-xl">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                src="{{ asset('storage/' . $note->image) }}" alt="{{ $note->name }}">
                        </div>
                    @else
                        <div class="h-52 bg-gray-100 flex items-center justify-center rounded-t-xl">
                            <i data-lucide="image" class="w-10 h-10 text-gray-300"></i>
                        </div>
                    @endif

                    <div class="p-4 md:p-6">
                        <!-- Categories Badge -->
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($note->categories as $cat)
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $cat->name }}
                                </span>
                            @endforeach
                        </div>

                        <h3 class="text-xl font-semibold text-gray-800 group-hover:text-blue-600 break-words line-clamp-2">
                            {{ $note->name }}
                        </h3>

                        <p class="mt-3 text-gray-500 line-clamp-3">
                            {{ $note->content }}
                        </p>
                    </div>
                </a>

                <div class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200">
                    <div class="w-full py-3 px-6 flex items-center gap-2 text-sm text-gray-500">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                        {{ $note->created_at->format('M d, Y') }}
                    </div>
                    <div class="w-full py-3 px-6 flex items-center gap-2 text-sm text-gray-500">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        {{ $note->user->name ?? __('Unknown') }}
                    </div>
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
            <i data-lucide="search" class="w-8 h-8 text-gray-400"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900">{{ __('No notes found') }}</h3>
        <p class="text-gray-500 mt-2">{{ __('Try adjusting your search or category filter.') }}</p>
        <a href="{{ route('home') }}"
            class="mt-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none transition">
            {{ __('Clear all filters') }}
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
@endif
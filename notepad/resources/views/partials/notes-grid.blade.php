@forelse($notes as $note)
    <a class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-2xl hover:shadow-xl hover:-translate-y-1 transition-all duration-300 dark:bg-slate-900 dark:border-gray-700 dark:shadow-slate-700/[.7]"
        href="{{ route('notes.show', $note) }}">
        <div class="h-56 flex flex-col justify-center items-center bg-gray-100 rounded-t-2xl overflow-hidden relative">
            @if($note->image_url)
                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                    src="{{ $note->image_url }}" alt="{{ $note->name }}">
            @else
                <div class="w-full h-full bg-gradient-to-br from-blue-500 to-violet-500 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white/80" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M2.5 1a1 1 0 0 0-1 1v1h1a1 1 0 0 1 1 1v1h1v-1a2 2 0 0 0-2-2H2.5zm10 14a1 1 0 0 0 1-1v-1h-1a1 1 0 0 1-1-1v-1h-1v1a2 2 0 0 0 2 2h2.5zM0 10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h-2.5a1 1 0 0 1-1-1V2.5L8 0H2a2 2 0 0 0-2 2v8zm8.5-5H11l-2.5 3v-3z" />
                    </svg>
                </div>
            @endif
        </div>
        <div class="p-5 md:p-6 flex flex-col flex-grow">
            <div class="mb-3">
                <span
                    class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                    {{ $note->categories->pluck('name')->join(', ') }}
                </span>
            </div>
            <h3
                class="text-xl font-bold text-gray-800 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                {{ $note->name }}
            </h3>
            <p class="mt-3 text-gray-500 line-clamp-3">
                {{ Str::limit($note->content, 120) }}
            </p>
        </div>

        <div class="mt-auto flex items-center justify-between p-5 md:p-6 pt-0">
            <div class="flex items-center gap-x-2">
                <img class="size-6 rounded-full object-cover"
                    src="https://ui-avatars.com/api/?name={{ urlencode($note->user->name) }}&background=EBF4FF&color=7F9CF5"
                    alt="{{ $note->user->name }}">
                <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                    {{ $note->user->name }}
                </span>
            </div>

            <button type="button" onclick="openPublicNoteModal({{ $note->id }})"
                class="inline-flex items-center gap-x-1 text-sm font-semibold text-blue-600 hover:text-blue-800 dark:text-blue-500 dark:hover:text-blue-400 transition-colors focus:outline-none">
                {{ __('Read More') }}
                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>
        </div>
    </a>
@empty
    <div class="col-span-full text-center py-10">
        <div class="inline-flex items-center justify-center p-4 bg-gray-50 rounded-full dark:bg-slate-800 mb-4">
            <svg class="size-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
        </div>
        <p class="text-gray-500 dark:text-gray-400 text-lg">{{ __('No notes found.') }}</p>
    </div>
@endforelse

<div class="mt-12 flex justify-center col-span-full w-full">
    {{ $notes->links() }}
</div>
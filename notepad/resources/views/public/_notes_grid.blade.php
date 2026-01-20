@forelse($notes as $note)
    <a class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition dark:bg-slate-900 dark:border-gray-700 dark:shadow-slate-700/[.7]"
        href="{{ route('public.show', $note->id) }}">
        @if($note->image)
            <div class="h-52 flex flex-col justify-center items-center bg-gray-100 rounded-t-xl overflow-hidden">
                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-in-out"
                    src="{{ asset('storage/' . $note->image) }}" alt="{{ $note->name }}">
            </div>
        @else
            <div
                class="h-52 flex flex-col justify-center items-center bg-gradient-to-br from-blue-100 to-violet-100 rounded-t-xl overflow-hidden">
                <i data-lucide="image-off" class="w-12 h-12 text-blue-300"></i>
            </div>
        @endif
        <div class="p-4 md:p-6">
            <div class="flex flex-wrap gap-2 mb-3">
                @foreach($note->categories as $cat)
                    <span
                        class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                        {{ trans()->has('category.names.' . $cat->name) ? __('category.names.' . $cat->name) : $cat->name }}
                    </span>
                @endforeach
            </div>
            <h3
                class="text-xl font-semibold text-gray-800 dark:text-gray-300 dark:hover:text-white line-clamp-2 break-words">
                {{ $note->name }}
            </h3>
            <p class="mt-3 text-gray-500 line-clamp-3 break-words">
                {{ $note->content }}
            </p>
        </div>
        <div class="mt-auto border-t border-gray-200 p-4 md:p-6 flex items-center justify-between">
            <div class="flex items-center gap-x-3">
                <div class="flex items-center gap-x-1.5 text-xs text-gray-500">
                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                    <span>{{ $note->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="flex items-center gap-x-1.5 text-xs text-gray-500">
                    <i data-lucide="user" class="w-3.5 h-3.5"></i>
                    <span>{{ $note->user->name ?? 'Unknown' }}</span>
                </div>
            </div>
            <div class="justify-end text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center gap-1">
                Read more <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </div>
        </div>
    </a>
@empty
    <div class="col-span-full text-center py-10">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
            <i data-lucide="file-x" class="w-8 h-8 text-gray-500"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-800">No notes found</h3>
        <p class="text-gray-500 mt-2">Try adjusting your search or filter.</p>
    </div>
@endforelse
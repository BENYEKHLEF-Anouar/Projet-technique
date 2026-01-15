@foreach($notes as $note)
    <tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-neutral-900 dark:even:bg-neutral-800">
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
            @if($note->image)
                <img src="{{ asset('storage/' . $note->image) }}" alt="{{ $note->name }}"
                    class="h-10 w-10 object-cover rounded-md">
            @else
                <span class="text-gray-400">-</span>
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $note->name }}
        </td>
        <td
            class="px-6 py-4 whitespace-normal break-words max-w-xs text-sm font-medium text-gray-800 dark:text-neutral-200">
            {{ Str::limit($note->content, 50) }}</td>
        <td
            class="px-6 py-4 whitespace-normal break-words max-w-xs text-sm font-medium text-gray-800 dark:text-neutral-200">
            <div class="flex flex-wrap gap-1">
                @forelse($note->categories as $cat)
                    <span
                        class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-lg text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $cat->name ?? $cat->nom }}
                    </span>
                @empty
                    <span class="text-gray-400">Aucune</span>
                @endforelse
            </div>
        </td>
    </tr>
@endforeach
@foreach($notes as $note)
    <tr>
        <!-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                @if($note->image)
                    <img src="{{ asset('storage/' . $note->image) }}" alt="{{ $note->name }}"
                        class="h-10 w-10 object-cover rounded-md">
                @else
                    <span class="text-gray-400">-</span>
                @endif
            </td> -->
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <a href="{{ route('public.show', $note->id) }}" target="_blank"
                class="text-blue-600 hover:text-blue-800 hover:underline inline-flex items-center gap-x-1.5"
                title="View article">
                {{ $note->name }}
                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
            </a>
        </td>
        <!-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ Str::limit($note->content, 50) }}</td> -->
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
            <div class="flex flex-wrap gap-1">
                @forelse($note->categories as $cat)
                    <span
                        class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-lg text-xs font-medium bg-blue-100 text-blue-800">
                        {{ trans()->has('category.names.' . $cat->name) ? __('category.names.' . $cat->name) : $cat->name }}
                    </span>
                @empty
                    <span class="text-gray-400">Aucune</span>
                @endforelse
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
            <div class="inline-flex gap-x-2">
                <button type="button" onclick="editNote({{ $note->id }})" title="{{ __('note.views.edit') ?? 'Edit' }}"
                    class="inline-flex items-center justify-center w-8 h-8 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:bg-blue-100 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:bg-blue-800/30">
                    <i data-lucide="pencil" class="w-4 h-4"></i>
                </button>
                <button type="button" onclick="deleteNote({{ $note->id }})"
                    title="{{ __('note.views.delete') ?? 'Delete' }}"
                    class="inline-flex items-center justify-center w-8 h-8 text-sm font-semibold rounded-lg border border-transparent text-red-600 hover:bg-red-100 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:hover:bg-red-800/30">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>
        </td>
    </tr>
@endforeach
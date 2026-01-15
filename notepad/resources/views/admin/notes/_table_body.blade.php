@foreach($notes as $note)
    <tr>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
            @if($note->image)
                <img src="{{ asset('storage/' . $note->image) }}" alt="{{ $note->name }}"
                    class="h-10 w-10 object-cover rounded-md">
            @else
                <span class="text-gray-400">-</span>
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $note->name }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ Str::limit($note->content, 50) }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
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
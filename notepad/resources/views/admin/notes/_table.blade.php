<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categories</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($notes as $note)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <!-- @if($note->image)
                                    <img src="{{ asset('storage/' . $note->image) }}" alt="{{ $note->name }}" class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i data-lucide="file-text" class="w-5 h-5 text-gray-400"></i>
                                    </div>
                                @endif -->
                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($note->name, 40) }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($note->categories as $cat)
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-indigo-50 text-indigo-600 border border-indigo-100">{{ $cat->name }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600">{{ $note->user->name ?? 'Unknown' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600">{{ $note->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('notes.show', $note->id) }}" target="_blank" class="p-2 text-gray-400 hover:text-indigo-600 transition" title="View">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.notes.edit', $note->id) }}" class="p-2 text-gray-400 hover:text-indigo-600 transition" title="Edit">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.notes.destroy', $note->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this note?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition" title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <i data-lucide="inbox" class="w-8 h-8 text-gray-400"></i>
                            </div>
                            <p class="text-gray-600">No notes found</p>
                            <p class="text-sm text-gray-500 mt-1">Try adjusting your filters or create a new note</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($notes->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 pagination-container">
            {{ $notes->onEachSide(1)->links() }}
        </div>
    @endif
</div>

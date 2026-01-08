@if($notes->count() > 0)
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="border rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">{{ __('Name') }}</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">{{ __('Categories') }}</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">{{ __('Author') }}</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">{{ __('Updated At') }}</th>
                                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($notes as $note)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                        {{ $note->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($note->categories as $category)
                                                <span class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-lg text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $category->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        {{ $note->user->name ?? __('Unknown') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        {{ $note->updated_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <button type="button" onclick="openViewModal({{ $note->id }})" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-gray-600 hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:text-blue-600">
                                            {{ __('View') }}
                                        </button>
                                        <button type="button" onclick="openEditModal({{ $note->id }})" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:text-blue-800 ml-2">
                                            {{ __('Edit') }}
                                        </button>
                                        <form action="{{ route('admin.notes.destroy', $note->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('{{ __('Are you sure you want to delete this note?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-red-600 hover:text-red-800 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:text-red-800">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $notes->links('pagination::tailwind') }}
    </div>
@else
    <div class="text-center py-10 px-4 sm:px-6 lg:px-8">
        <div class="inline-block bg-gray-100 rounded-full p-4 mb-4">
            <i data-lucide="file-x" class="w-6 h-6 text-gray-500"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-800">
            {{ __('No notes found') }}
        </h3>
        <p class="mt-1 text-gray-500">
            {{ __('Try adjusting your filters or create a new note to start.') }}
        </p>
        <div class="mt-5">
            <button type="button" onclick="openCreateModal()" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                <i data-lucide="plus" class="w-4 h-4"></i>
                {{ __('Create Note') }}
            </button>
        </div>
    </div>
@endif
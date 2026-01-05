<div class="overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <!-- <th scope="col"
                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Image
                </th> -->
                <th scope="col"
                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Name
                </th>
                <th scope="col"
                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                    Author</th>
                <th scope="col"
                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                    Categories</th>
                <th scope="col"
                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Content
                </th>
                <th scope="col"
                    class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Action
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($notes as $note)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $note->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                        <div class="flex items-center gap-x-2">
                            <img class="size-6 rounded-full object-cover"
                                src="https://ui-avatars.com/api/?name={{ urlencode($note->user->name) }}&background=EBF4FF&color=7F9CF5"
                                alt="{{ $note->user->name }}">
                            <span>{{ $note->user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                        @foreach($note->categories as $category)
                            <span
                                class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">{{ $category->name }}</span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200 truncate max-w-xs">
                        {{ Str::limit($note->content, 50) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                        <button type="button" data-id="{{ $note->id }}"
                            class="view-note-btn text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300 mr-2">View</button>
                        <button type="button" data-id="{{ $note->id }}"
                            class="edit-note-btn text-blue-600 hover:text-blue-900 dark:text-blue-500 dark:hover:text-blue-400 mr-2">Edit</button>
                        <button type="button" data-id="{{ $note->id }}"
                            class="delete-note-btn text-red-600 hover:text-red-900 dark:text-red-500 dark:hover:text-red-400">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No notes found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="py-1 px-4">
    {{ $notes->links() }}
</div>
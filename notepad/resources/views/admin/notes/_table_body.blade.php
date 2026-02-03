{{-- Notes Table Body Rows --}}
<template x-for="note in notes" :key="note.id">
    <tr>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
            <a :href="`{{ url('/note') }}/${note.id}`" target="_blank"
                class="inline-flex items-center gap-x-1 text-blue-600 hover:text-blue-700 hover:underline dark:text-blue-500 dark:hover:text-blue-400">
                <span x-text="note.name"></span>
                <i data-lucide="external-link" class="size-3"></i>
            </a>
        </td>
        <td class="px-6 py-4 text-sm text-gray-800 dark:text-neutral-200">
            <div class="truncate max-w-xs" x-text="note.content"></div>
        </td>
        <td class="px-6 py-4 text-sm text-gray-800 dark:text-neutral-200">
            <div class="flex flex-wrap gap-1">
                <template x-for="cat in note.categories" :key="cat.id">
                    <span
                        class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500"
                        x-text="cat.name"></span>
                </template>
            </div>
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
            <div class="flex justify-end gap-x-2" x-show="userRole === 'admin' || note.user_id === currentUserId">
                {{-- Edit --}}
                <button type="button" @click="openEditModal(note)"
                    class="inline-flex items-center justify-center size-8 rounded-lg text-blue-600 hover:bg-blue-50 dark:text-blue-500 dark:hover:bg-blue-900/30"
                    title="{{ __('note.views.edit') }}">
                    <i data-lucide="pencil" class="size-4"></i>
                </button>
                {{-- Delete --}}
                <button type="button" @click="deleteNote(note.id)"
                    class="inline-flex items-center justify-center size-8 rounded-lg text-red-600 hover:bg-red-50 dark:text-red-500 dark:hover:bg-red-900/30"
                    title="{{ __('note.views.delete') }}">
                    <i data-lucide="trash-2" class="size-4"></i>
                </button>
            </div>
        </td>
    </tr>
</template>
<template x-if="notes.length === 0">
    <tr>
        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
            {{ __('note.views.no_notes_found') }}
        </td>
    </tr>
</template>
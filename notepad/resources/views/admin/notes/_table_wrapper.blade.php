<div id="table-wrapper">
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div
                    class="border border-gray-200 rounded-lg shadow-xs overflow-hidden dark:border-neutral-700 dark:shadow-gray-900">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                        <thead class="bg-gray-50 dark:bg-neutral-700">
                            <tr>
                                <!-- <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                    {{ __('note.attributes.image') }}
                                </th> -->
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                    {{ __('note.attributes.name') }}
                                </th>
                                <!-- <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                    {{ __('note.attributes.content') }}
                                </th> -->
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                    {{ __('note.attributes.categories') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                    {{ __('note.views.actions') ?? 'Actions' }}
                                </th>
                            </tr>
                        </thead>
                        <tbody id="notes-table" class="divide-y divide-gray-200 dark:divide-neutral-700">
                            @include('admin.notes._table_body')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $notes->links() }}
        </div>
    </div>
</div>
<div id="table-wrapper">
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div
                    class="border rounded-lg shadow-sm overflow-hidden dark:border-neutral-700 dark:shadow-neutral-900">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                        <thead class="bg-gray-50 dark:bg-neutral-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                    {{ __('note.attributes.name') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                    {{ __('note.attributes.content') }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                    {{ __('note.attributes.categories') }}
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                    {{ __('note.views.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody id="notes-table-body" class="divide-y divide-gray-200 dark:divide-neutral-700">
                            @include('admin.notes._table_body')
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer (Pagination) -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-neutral-700">
                    {{ $notes->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
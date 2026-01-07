<div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm overflow-hidden animate-slide-up"
    style="animation-delay: 0.1s;">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50/50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        {{ __('Note') }}
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        {{ __('Category') }}
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        {{ __('Author') }}
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        {{ __('Last Updated') }}
                    </th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        {{ __('Actions') }}
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($notes as $note)
                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <!-- @if($note->image)
                                    <img src="{{ asset('storage/' . $note->image) }}" alt=""
                                        class="w-10 h-10 rounded-lg object-cover ring-2 ring-gray-100">
                                @else
                                    <div
                                        class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                        <i data-lucide="file-text" class="w-5 h-5"></i>
                                    </div>
                                @endif -->
                                <div class="font-semibold text-gray-900">{{ Str::limit($note->name, 40) }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($note->categories as $cat)
                                    <span
                                        class="px-2.5 py-1 text-xs font-medium rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">{{ $cat->name }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600 flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                    {{ substr($note->user->name ?? '?', 0, 1) }}
                                </div>
                                {{ $note->user->name ?? 'Inconnu' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $note->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex justify-end items-center gap-1">
                                <button type="button" onclick="openViewModal({{ $note->id }})"
                                    class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                    title="Voir">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                                <button type="button" onclick="openEditModal({{ $note->id }})"
                                    class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all"
                                    title="Modifier">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>
                                <form action="{{ route('admin.notes.destroy', $note->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                        title="Supprimer">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div
                                class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 mb-4 ring-8 ring-gray-50">
                                <i data-lucide="inbox" class="w-10 h-10 text-gray-300"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Aucune note trouvée</h3>
                            <p class="text-gray-500 mt-1 max-w-sm mx-auto">Essayez d'ajuster vos filtres ou créez une
                                nouvelle note pour commencer.</p>
                            <button onclick="openCreateModal()"
                                class="mt-4 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                                Créer une Note
                            </button>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($notes->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 pagination-container">
            {{ $notes->onEachSide(1)->links() }}
        </div>
    @endif
</div>
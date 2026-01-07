{{-- View Note Modal --}}
<div id="view-note-modal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden">
        {{-- Modal Header --}}
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-900">Détails de la Note</h3>
            <button type="button" onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-140px)]">
            <div id="view-note-content" class="space-y-6">
                {{-- Content will be loaded dynamically --}}
                <div class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
                    <p class="text-gray-600 mt-2">Chargement...</p>
                </div>
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
            <button type="button" onclick="closeViewModal()"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Fermer
            </button>
        </div>
    </div>
</div>
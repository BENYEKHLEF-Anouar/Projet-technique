{{-- Create/Edit Note Modal --}}
<div id="form-note-modal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden">
        {{-- Modal Header --}}
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h3 id="modal-title" class="text-xl font-bold text-gray-900">Créer une Nouvelle Note</h3>
            <button type="button" onclick="closeFormModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        {{-- Form --}}
        <form id="note-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="note-id" name="note_id">
            <input type="hidden" id="form-method" name="_method" value="POST">

            {{-- Modal Body --}}
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)] space-y-6">

                {{-- Error Messages Container --}}
                <div id="form-errors" class="hidden p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                    <div class="flex items-start gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                        <div id="error-messages" class="flex-1 text-sm"></div>
                    </div>
                </div>

                {{-- Note Title --}}
                <div>
                    <label for="note-name" class="block text-sm font-medium text-gray-700 mb-2">
                        Titre de la Note <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="note-name" name="name"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                        placeholder="Entrez le titre de la note...">
                    <p id="error-name" class="mt-1 text-xs text-red-600 hidden"></p>
                </div>

                {{-- Content --}}
                <div>
                    <label for="note-content" class="block text-sm font-medium text-gray-700 mb-2">
                        Contenu <span class="text-red-500">*</span>
                    </label>
                    <textarea id="note-content" name="content" rows="8"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                        placeholder="Écrivez le contenu de votre note ici..."></textarea>
                    <p id="error-content" class="mt-1 text-xs text-red-600 hidden"></p>
                </div>

                {{-- Categories --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Catégories <span class="text-red-500">*</span>
                    </label>
                    <div id="categories-container" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($categories as $category)
                            <label
                                class="relative flex items-start p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                                <input type="checkbox" name="category_ids[]" value="{{ $category->id }}"
                                    class="mt-0.5 rounded text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-3 text-sm text-gray-700">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p id="error-category_ids" class="mt-1 text-xs text-red-600 hidden"></p>
                </div>

                {{-- Image Upload with Preview --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Image de Couverture
                    </label>

                    {{-- Current Image (for edit mode) --}}
                    <div id="current-image-container" class="hidden mb-4">
                        <p class="text-sm text-gray-600 mb-2">Image actuelle :</p>
                        <img id="current-image" src="" alt="Current cover"
                            class="w-48 h-32 object-cover rounded-lg border border-gray-200">
                    </div>

                    {{-- Upload Area --}}
                    <div class="flex flex-col gap-4">
                        <label
                            class="flex flex-col items-center px-4 py-6 bg-white border-2 border-gray-200 border-dashed rounded-lg cursor-pointer hover:bg-gray-50 transition">
                            <i data-lucide="upload" class="w-8 h-8 text-gray-400 mb-2"></i>
                            <span class="text-sm text-gray-600">Cliquez pour télécharger ou glissez-déposez</span>
                            <span class="text-xs text-gray-500 mt-1">PNG, JPG ou GIF (MAX. 2MB)</span>
                            <input type="file" id="note-image" name="image" accept="image/*" class="hidden"
                                onchange="handleImagePreview(this)">
                        </label>

                        {{-- Image Preview --}}
                        <div id="image-preview-container" class="hidden">
                            <p class="text-sm text-gray-600 mb-2">Aperçu de la nouvelle image :</p>
                            <div class="relative inline-block">
                                <img id="image-preview" src="" alt="Preview"
                                    class="w-48 h-32 object-cover rounded-lg border border-gray-200">
                                <button type="button" onclick="clearImagePreview()"
                                    class="absolute -top-2 -right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" onclick="closeFormModal()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Annuler
                </button>
                <button type="submit" id="submit-btn"
                    class="px-6 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                    Créer la Note
                </button>
            </div>
        </form>
    </div>
</div>
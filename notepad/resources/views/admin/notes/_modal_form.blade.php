{{-- Create/Edit Note Modal --}}
<div id="form-note-modal"
    class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4 opacity-0 transition-opacity duration-300"
    aria-hidden="true">
    <div
        class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden transform scale-95 transition-transform duration-300">
        {{-- Modal Header --}}
        <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 id="modal-title" class="text-xl font-bold text-gray-900">Créer une Nouvelle Note</h3>
            <button type="button" onclick="closeFormModal()"
                class="p-2 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                <i data-lucide="x" class="w-5 h-5"></i>
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
                <div id="form-errors" class="hidden p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                    <div class="flex items-start gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                        <div id="error-messages" class="flex-1 text-sm font-medium"></div>
                    </div>
                </div>

                {{-- Note Title --}}
                <div class="group">
                    <label for="note-name"
                        class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-indigo-600 transition-colors">
                        Titre de la Note <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="note-name" name="name"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-gray-400"
                        placeholder="Entrez le titre de la note...">
                    <p id="error-name" class="mt-1.5 text-xs text-red-600 hidden font-medium flex items-center gap-1">
                        <i data-lucide="info" class="w-3 h-3"></i> <span></span>
                    </p>
                </div>

                {{-- Content --}}
                <div class="group">
                    <label for="note-content"
                        class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-indigo-600 transition-colors">
                        Contenu <span class="text-red-500">*</span>
                    </label>
                    <textarea id="note-content" name="content" rows="8"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:text-gray-400 leading-relaxed"
                        placeholder="Écrivez le contenu de votre note ici..."></textarea>
                    <p id="error-content"
                        class="mt-1.5 text-xs text-red-600 hidden font-medium flex items-center gap-1">
                        <i data-lucide="info" class="w-3 h-3"></i> <span></span>
                    </p>
                </div>

                {{-- Categories --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Catégories <span class="text-red-500">*</span>
                    </label>
                    <div id="categories-container" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($categories as $category)
                            <label class="relative group">
                                <input type="checkbox" name="category_ids[]" value="{{ $category->id }}"
                                    class="peer hidden">
                                <span
                                    class="flex items-center p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition-all peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-700">
                                    <span
                                        class="w-4 h-4 mr-3 flex items-center justify-center border border-gray-300 rounded text-indigo-600 peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all">
                                        <i data-lucide="check"
                                            class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100"></i>
                                    </span>
                                    <span class="text-sm font-medium">{{ $category->name }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                    <p id="error-category_ids"
                        class="mt-1.5 text-xs text-red-600 hidden font-medium flex items-center gap-1">
                        <i data-lucide="info" class="w-3 h-3"></i> <span></span>
                    </p>
                </div>

                {{-- Image Upload with Preview --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Image de Couverture
                    </label>

                    {{-- Current Image (for edit mode) --}}
                    <div id="current-image-container"
                        class="hidden mb-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-sm text-gray-600 mb-3 font-medium">Image actuelle :</p>
                        <div class="relative w-fit group">
                            <img id="current-image" src="" alt="Current cover"
                                class="w-48 h-32 object-cover rounded-lg shadow-sm">
                            <div
                                class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors rounded-lg pointer-events-none">
                            </div>
                        </div>
                    </div>

                    {{-- Upload Area --}}
                    <div class="flex flex-col gap-4">
                        <label
                            class="flex flex-col items-center px-6 py-8 bg-white border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-gray-50 hover:border-indigo-400 transition-all group">
                            <div
                                class="p-3 bg-indigo-50 text-indigo-600 rounded-lg mb-3 group-hover:scale-110 transition-transform">
                                <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                            </div>
                            <span
                                class="text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">Cliquez
                                pour télécharger ou glissez-déposez</span>
                            <span class="text-xs text-gray-500 mt-1">PNG, JPG ou GIF (MAX. 2MB)</span>
                            <input type="file" id="note-image" name="image" accept="image/*" class="hidden"
                                onchange="handleImagePreview(this)">
                        </label>

                        {{-- Image Preview --}}
                        <div id="image-preview-container" class="hidden animate-fade-in">
                            <p class="text-sm text-gray-600 mb-2 font-medium">Aperçu de la nouvelle image :</p>
                            <div class="relative inline-block group">
                                <img id="image-preview" src="" alt="Preview"
                                    class="w-48 h-32 object-cover rounded-xl border border-gray-200 shadow-md">
                                <button type="button" onclick="clearImagePreview()"
                                    class="absolute -top-2 -right-2 p-1.5 bg-white text-red-500 border border-red-100 rounded-full hover:bg-red-50 hover:text-red-600 shadow-sm transition-all transform hover:scale-110">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="px-6 py-4 bg-gray-50/80 border-t border-gray-200 flex justify-end gap-3 backdrop-blur-sm">
                <button type="button" onclick="closeFormModal()"
                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
                    Annuler
                </button>
                <button type="submit" id="submit-btn"
                    class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-violet-600 rounded-xl hover:shadow-lg hover:shadow-indigo-500/30 transition-all transform active:scale-95">
                    Créer la Note
                </button>
            </div>
        </form>
    </div>
</div>
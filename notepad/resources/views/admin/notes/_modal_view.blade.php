{{-- View Note Modal --}}
<div id="view-note-modal"
    class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4 opacity-0 transition-opacity duration-300"
    aria-hidden="true">
    <div
        class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] flex flex-col overflow-hidden transform scale-95 transition-transform duration-300">
        {{-- Modal Header --}}
        <div class="flex-none flex items-center justify-between p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-xl font-bold text-gray-900 tracking-tight">{{ __('Note Details') }}</h3>
            <button type="button" onclick="closeViewModal()"
                class="p-2 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="flex-1 p-6 overflow-y-auto min-h-0">
            <div id="view-note-content" class="space-y-8">
                {{-- Content will be loaded dynamically --}}
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="relative">
                        <div class="w-12 h-12 rounded-full border-2 border-indigo-100 border-t-indigo-600 animate-spin">
                        </div>
                    </div>
                    <p class="text-gray-500 mt-4 font-medium animate-pulse">{{ __('Loading...') }}</p>
                </div>
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="flex-none px-6 py-4 bg-gray-50/80 border-t border-gray-200 flex justify-end gap-3 backdrop-blur-sm">
            <button type="button" onclick="closeViewModal()"
                class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
                {{ __('Close') }}
            </button>
        </div>
    </div>
</div>
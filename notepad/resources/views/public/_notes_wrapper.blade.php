<div id="notes-wrapper">
    <!-- Grid -->
    <div id="notes-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @include('public._notes_grid')
    </div>
    <!-- End Grid -->

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $notes->links() }}
    </div>
</div>
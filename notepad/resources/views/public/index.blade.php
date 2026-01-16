@extends('layouts.public')

@section('content')
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Title & Search -->
        <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight">
                {{ __('note.views.latest_notes') ?? 'Latest Notes' }}
            </h2>
            <p class="mt-1 text-gray-600">{{ __('note.views.explore_ideas') ?? 'Explore ideas and creativity.' }}</p>
        </div>
        <!-- End Title & Search -->

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
@endsection
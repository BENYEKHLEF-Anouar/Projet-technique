@extends('layouts.admin')

@section('header-title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Welcome to Admin Panel</h2>
        <p class="text-gray-600 mt-1">Manage your notes and categories from here</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Notes -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-50 rounded-lg">
                    <i data-lucide="notebook" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Notes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Note::count() }}</p>
                </div>
            </div>
        </div>

        <!-- Total Categories -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-purple-50 rounded-lg">
                    <i data-lucide="tags" class="w-6 h-6 text-purple-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Categories</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Category::count() }}</p>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-orange-50 rounded-lg">
                    <i data-lucide="users" class="w-6 h-6 text-orange-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Notes -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Recent Notes</h3>
            <a href="{{ route('admin.notes.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                View All →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Categories</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse(\App\Models\Note::with(['user', 'categories'])->latest()->take(5)->get() as $note)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $note->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600">{{ $note->user->name ?? 'Unknown' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($note->categories->take(2) as $cat)
                                        <span class="px-2 py-0.5 text-xs rounded-full bg-indigo-50 text-indigo-600">
                                            {{ $cat->name }}
                                        </span>
                                    @endforeach
                                    @if($note->categories->count() > 2)
                                        <span class="px-2 py-0.5 text-xs text-gray-500">
                                            +{{ $note->categories->count() - 2 }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600">{{ $note->created_at->format('M d, Y') }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                No notes available yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
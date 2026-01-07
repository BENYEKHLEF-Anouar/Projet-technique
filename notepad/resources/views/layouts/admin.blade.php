<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Memo Notepad</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 hidden lg:block">
            <div class="p-6 border-b border-gray-200">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-2 text-xl font-bold text-indigo-600">
                    <i data-lucide="layout-dashboard" class="w-6 h-6"></i>
                    <span>Admin Panel</span>
                </a>
            </div>

            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i data-lucide="home" class="w-5 h-5"></i>
                    Dashboard
                </a>

                <a href="{{ route('admin.notes.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.notes.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i data-lucide="notebook" class="w-5 h-5"></i>
                    Manage Notes
                </a>

                <div class="pt-4 mt-4 border-t border-gray-200">
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition">
                        <i data-lucide="external-link" class="w-5 h-5"></i>
                        View Website
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6">
                <div class="flex items-center gap-4">
                    <button class="lg:hidden text-gray-500">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-900">@yield('header-title', 'Admin Dashboard')</h1>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600">Administrator</span>
                    <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center">
                        <span class="text-sm font-bold text-indigo-700">A</span>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6 lg:p-8">
                @if(session('success'))
                    <div
                        class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>
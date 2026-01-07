<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tableau de Bord Admin - Memo Notepad</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside
            class="w-64 glass border-r border-gray-200/50 hidden lg:block fixed h-full z-40 transition-all duration-300">
            <div class="p-6 border-b border-gray-100">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-2.5 text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-600">
                    <div class="p-1.5 bg-indigo-100 rounded-lg text-indigo-600">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    </div>
                    <span>Panneau Admin</span>
                </a>
            </div>

            <nav class="p-4 space-y-1.5 h-[calc(100vh-80px)] overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50/80 hover:text-gray-900' }}">
                    <i data-lucide="home"
                        class="w-5 h-5 transition-transform group-hover:scale-110 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                    {{ __('Dashboard') }}
                </a>

                <a href="{{ route('admin.notes.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.notes.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50/80 hover:text-gray-900' }}">
                    <i data-lucide="notebook"
                        class="w-5 h-5 transition-transform group-hover:scale-110 {{ request()->routeIs('admin.notes.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                    {{ __('Notes') }}
                </a>

                <div class="pt-4 mt-4 border-t border-gray-100">
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50/80 hover:text-gray-900 transition-all duration-200 group">
                        <i data-lucide="external-link"
                            class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-transform group-hover:translate-x-0.5"></i>
                        {{ __('Home') }}
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-64 transition-all duration-300">
            <!-- Header -->
            <header
                class="glass border-b border-gray-200/50 h-16 flex items-center justify-between px-6 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button class="lg:hidden text-gray-500 hover:text-gray-700 transition">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-800 tracking-tight">
                        @yield('header-title', 'Tableau de Bord Admin')</h1>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-gray-600">Administrateur</span>
                    <div
                        class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-100 to-violet-100 border border-indigo-200 flex items-center justify-center shadow-sm">
                        <span class="text-sm font-bold text-indigo-700">A</span>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6 lg:p-8">
                @if(session('success'))
                    <div
                        class="mb-6 p-4 bg-green-50/50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3 animate-fade-in shadow-sm">
                        <div class="p-1 bg-green-100 rounded-full">
                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                        </div>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div
                        class="mb-6 p-4 bg-red-50/50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3 animate-fade-in shadow-sm">
                        <div class="p-1 bg-red-100 rounded-full">
                            <i data-lucide="alert-circle" class="w-5 h-5"></i>
                        </div>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>
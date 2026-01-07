<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memo Notepad</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Navbar -->
    <header class="glass sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <div
                    class="p-2 bg-indigo-600 rounded-lg text-white shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform duration-300">
                    <i data-lucide="notebook-pen" class="w-5 h-5"></i>
                </div>
                <span
                    class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-700">Memo
                    Notepad</span>
            </a>

            <nav class="hidden sm:flex items-center gap-6">
                <!-- Language Switcher -->
                <div class="flex items-center gap-2 text-sm font-medium">
                    <a href="{{ route('lang.switch', 'fr') }}"
                        class="{{ app()->getLocale() == 'fr' ? 'text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md' : 'text-gray-500 hover:text-gray-900 px-2 py-1' }} transition-colors">
                        FR
                    </a>
                    <span class="text-gray-300">/</span>
                    <a href="{{ route('lang.switch', 'en') }}"
                        class="{{ app()->getLocale() == 'en' ? 'text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md' : 'text-gray-500 hover:text-gray-900 px-2 py-1' }} transition-colors">
                        EN
                    </a>
                </div>

                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors rounded-full hover:bg-indigo-50/80">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    {{ __('Dashboard') }}
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-[calc(100vh-140px)]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-8 border-t border-gray-200/60 bg-white/50 backdrop-blur-sm">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center gap-4">
            <div class="flex items-center gap-2 opacity-50">
                <i data-lucide="notebook-pen" class="w-4 h-4"></i>
                <span class="text-sm font-semibold">Memo Notepad</span>
            </div>
            <p class="text-sm text-gray-500">
                &copy; {{ date('Y') }} Memo Notepad. Tous droits réservés.
            </p>
        </div>
    </footer>


</body>

</html>
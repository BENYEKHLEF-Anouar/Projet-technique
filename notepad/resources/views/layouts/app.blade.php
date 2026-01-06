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
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-indigo-600 hover:text-indigo-700 transition">
                <i data-lucide="notebook-pen" class="w-6 h-6"></i>
                Memo Notepad
            </a>
            
            <nav class="hidden sm:flex gap-4">
               <!-- Add links if needed -->
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-6 border-t border-gray-200 bg-white">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Memo Notepad. All rights reserved.
        </div>
    </footer>

</body>
</html>
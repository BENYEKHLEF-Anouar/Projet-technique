<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memo Notepad</title>
    <!-- <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"> -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Navbar -->
    <header class="flex flex-wrap sm:justify-start sm:flex-nowrap z-50 w-full bg-white border-b border-gray-200 text-sm py-4">
        <nav class="max-w-[85rem] w-full mx-auto px-4 sm:px-6 lg:px-8 flex basis-full items-center justify-between" aria-label="Global">
            <a class="flex-none text-xl font-semibold text-gray-900" href="{{ route('home') }}">
                Memo Notepad
            </a>

            <div class="flex items-center gap-5">
                <!-- Language Switcher -->
                <div class="flex items-center gap-2 text-sm font-medium border-r border-gray-200 pr-5">
                    <a href="{{ route('lang.switch', 'fr') }}"
                        class="{{ app()->getLocale() == 'fr' ? 'text-blue-600' : 'text-gray-500 hover:text-blue-600' }}">
                        FR
                    </a>
                    <span class="text-gray-300">/</span>
                    <a href="{{ route('lang.switch', 'en') }}"
                        class="{{ app()->getLocale() == 'en' ? 'text-blue-600' : 'text-gray-500 hover:text-blue-600' }}">
                        EN
                    </a>
                </div>

                <a href="{{ route('admin.dashboard') }}"
                    class="font-medium text-gray-600 hover:text-blue-600">
                    {{ __('Dashboard') }}
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-[calc(100vh-140px)]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto border-t border-gray-200 text-center">
        <p class="text-gray-500">
            &copy; {{ date('Y') }} Memo Notepad. {{ __('All rights reserved.') }}
        </p>
    </footer>


</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', __('note.views.brand_name')) }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style> -->
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- Header -->
    <header
        class="flex flex-wrap sm:justify-start sm:flex-nowrap w-full bg-white text-sm py-4 border-b border-gray-200">
        <nav class="max-w-[85rem] w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between" aria-label="Global">
            <a class="flex-none text-xl font-bold text-blue-600"
                href="{{ route('public.index') }}">{{ __('note.views.brand_name') }}</a>
            <div class="flex flex-row items-center gap-5 mt-5 sm:justify-end sm:mt-0 sm:ps-5">
                <!-- Language Switcher -->
                <div class="flex items-center gap-x-2 border-r border-gray-200 pe-5">
                    <a href="{{ route('lang.switch', 'en') }}"
                        class="text-xs font-semibold {{ app()->getLocale() == 'en' ? 'text-blue-600' : 'text-gray-500 hover:text-blue-600' }}">EN</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('lang.switch', 'fr') }}"
                        class="text-xs font-semibold {{ app()->getLocale() == 'fr' ? 'text-blue-600' : 'text-gray-500 hover:text-blue-600' }}">FR</a>
                </div>
                <a class="font-medium text-gray-600 hover:text-blue-600 inline-flex items-center gap-x-1.5"
                    href="{{ route('notes.index') }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    {{ __('note.views.admin_dashboard') }}
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main id="content" role="main">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-10 bg-white border-t border-gray-200">
        <div class="max-w-[85rem] mx-auto px-4">
            <p class="text-gray-500 text-sm text-center">© {{ date('Y') }} {{ __('note.views.brand_name') }}.
                {{ __('note.views.all_rights_reserved') }}
            </p>
        </div>
    </footer>
</body>

</html>
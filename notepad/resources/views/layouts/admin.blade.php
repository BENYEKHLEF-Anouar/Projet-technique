<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- expose the CSRF token to the frontend (HTML and JavaScript). -->
    <title>{{ __('Admin Dashboard') }} - Memo Notepad</title>
    <!-- <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"> -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">

    <!-- Navigation Toggle -->
    <div class="sticky top-0 inset-x-0 z-20 bg-white border-y px-4 sm:px-6 md:px-8 lg:hidden">
        <div class="flex items-center py-4">
            <button type="button" class="text-gray-500 hover:text-gray-600" data-hs-overlay="#application-sidebar"
                aria-controls="application-sidebar" aria-label="Toggle navigation">
                <span class="sr-only">Toggle Navigation</span>
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>
    </div>
    <!-- End Navigation Toggle -->

    <!-- Sidebar -->
    <div id="application-sidebar"
        class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-r border-gray-200 pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
        <div class="px-6">
            <a class="flex-none text-xl font-semibold text-gray-900" href="{{ route('admin.dashboard') }}"
                aria-label="Brand">{{ __('Admin Panel') }}</a>
        </div>

        <nav class="hs-accordion-group p-6 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
            <ul class="space-y-1.5">
                <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 font-semibold' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <i data-lucide="home" class="w-4 h-4"></i>
                        {{ __('Dashboard') }}
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.notes.*') ? 'bg-gray-100 font-semibold' : '' }}"
                        href="{{ route('admin.notes.index') }}">
                        <i data-lucide="notebook" class="w-4 h-4"></i>
                        {{ __('Notes') }}
                    </a>
                </li>
                <li class="pt-4 mt-4 border-t border-gray-200">
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100"
                        href="{{ route('home') }}">
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                        {{ __('Home') }}
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- End Sidebar -->

    <!-- Content -->
    <div class="w-full pt-10 px-4 sm:px-6 md:px-8 lg:ps-72">
        <header class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-800">
                @yield('header-title', __('Admin Dashboard'))
            </h1>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600">{{ __('Administrator') }}</span>
                <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 border border-gray-200">
                    <span class="text-xs font-medium text-gray-600">A</span>
                </div>
            </div>
        </header>

        <main>
            @if(session('success'))
                <div class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 mb-6" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-lucide="check-circle" class="h-5 w-5 text-teal-600 mt-0.5"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-sm text-teal-700 font-medium">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-t-2 border-red-500 rounded-lg p-4 mb-6" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-lucide="alert-circle" class="h-5 w-5 text-red-600 mt-0.5"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-sm text-red-700 font-medium">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
    </div>

</body>

</html>
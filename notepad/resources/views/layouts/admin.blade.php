<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- expose the CSRF token to the frontend (HTML and JavaScript). -->
    <title>{{ __('note.views.admin_dashboard') }} - {{ __('note.views.brand_name') }}</title>
    <!-- <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}"> -->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">

    <!-- Navigation Toggle -->
    <div class="sticky top-0 inset-x-0 z-20 bg-white border-y px-4 sm:px-6 md:px-8 lg:hidden">
        <div class="flex items-center py-4">
            <button type="button" class="text-gray-500 hover:text-gray-600" data-hs-overlay="#application-sidebar"
                aria-controls="application-sidebar" aria-label="Toggle navigation">
                <span class="sr-only">{{ __('note.views.toggle_nav') }}</span>
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>
    </div>
    <!-- End Navigation Toggle -->

    <!-- Sidebar -->
    <div id="application-sidebar"
        class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-r border-gray-200 pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
        <div class="px-6">
            <a class="flex-none text-xl font-semibold text-gray-900" href="{{ route('notes.index') }}"
                aria-label="Brand">{{ __('note.views.brand_name') }}</a>
        </div>

        <nav class="hs-accordion-group p-6 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
            <ul class="space-y-1.5">
                <li>
                    <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('notes.*') ? 'bg-gray-100 font-semibold' : '' }}"
                        href="{{ route('notes.index') }}">
                        <i data-lucide="notebook" class="w-4 h-4"></i>
                        {{ __('note.views.notes') }}
                    </a>
                </li>
            </ul>
        </nav>

        <div class="mt-auto p-6 border-t border-gray-200">
            <div class="flex items-center gap-x-3 mb-4 px-2.5">
                <div class="shrink-0">
                    <div
                        class="size-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                </div>
                <div class="grow">
                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role ?? 'member' }}</p>
                </div>
            </div>

            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 mb-1"
                href="{{ route('public.index') }}">
                <i data-lucide="globe" class="w-4 h-4"></i>
                {{ __('note.views.back_to_website') }}
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-red-600 rounded-lg hover:bg-red-50">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    {{ __('Logout') }}
                </button>
            </form>
        </div>
    </div>
    <!-- End Sidebar -->

    <!-- Content -->
    <div class="w-full pt-10 px-4 sm:px-6 md:px-8 lg:ps-72">

        <main>
            <!-- Notifications -->
            <!-- Notification Container -->
            <div id="notification-container" class="fixed top-4 right-4 z-[100] min-w-[300px]"></div>

            @if(session('success'))
                <script>
                    window.addEventListener('DOMContentLoaded', () => {
                        if (window.showNotification) window.showNotification("{{ session('success') }}", 'success');
                    });
                </script>
            @endif
            @if(session('error'))
                <script>
                    window.addEventListener('DOMContentLoaded', () => {
                        if (window.showNotification) window.showNotification("{{ session('error') }}", 'error');
                    });
                </script>
            @endif

            @yield('content')
        </main>
    </div>
    </div>

</body>

</html>
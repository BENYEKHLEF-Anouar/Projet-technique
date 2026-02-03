@extends('layouts.public')

@section('content')
    <div class="min-h-[calc(100vh-200px)] flex items-center justify-center py-16">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 dark:bg-neutral-800 dark:border-neutral-700">
                <!-- Card Header -->
                <div class="p-6 sm:p-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                        {{ __('Login') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                        {{ __('note.views.brand_name') }}
                    </p>
                </div>

                <!-- Card Body -->
                <div class="p-6 sm:p-8 pt-0">
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium mb-2 dark:text-white">
                                {{ __('Email Address') }}
                            </label>
                            <div class="relative">
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                    class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('email') border-red-500 @enderror"
                                    placeholder="you@example.com">
                                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                    <i data-lucide="mail" class="w-4 h-4 text-gray-400"></i>
                                </div>
                            </div>
                            @error('email')
                                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium mb-2 dark:text-white">
                                {{ __('Password') }}
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required
                                    class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                    <i data-lucide="lock" class="w-4 h-4 text-gray-400"></i>
                                </div>
                            </div>
                            @error('password')
                                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}
                                    class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                <label for="remember" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            {{ __('Login') }}
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>

                        <!-- Register Link -->
                        @if (Route::has('register'))
                            <p class="mt-4 text-center text-sm text-gray-600 dark:text-neutral-400">
                                {{ __('note.auth.dont_have_account') }}
                                <a class="text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500"
                                    href="{{ route('register') }}">
                                    {{ __('note.auth.register_here') }}
                                </a>
                            </p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.public')

@section('content')
    <div class="min-h-[calc(100vh-200px)] flex items-center justify-center py-16">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 dark:bg-neutral-800 dark:border-neutral-700">
                <!-- Card Header -->
                <div class="p-6 sm:p-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                        {{ __('Register') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                        {{ __('note.auth.create_account') }}
                    </p>
                </div>

                <!-- Card Body -->
                <div class="p-6 sm:p-8 pt-0">
                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium mb-2 dark:text-white">
                                {{ __('Name') }}
                            </label>
                            <div class="relative">
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                                    class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('name') border-red-500 @enderror"
                                    placeholder="John Doe">
                                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                    <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                                </div>
                            </div>
                            @error('name')
                                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium mb-2 dark:text-white">
                                {{ __('Email Address') }}
                            </label>
                            <div class="relative">
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
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

                        <!-- Confirm Password -->
                        <div>
                            <label for="password-confirm" class="block text-sm font-medium mb-2 dark:text-white">
                                {{ __('Confirm Password') }}
                            </label>
                            <div class="relative">
                                <input type="password" id="password-confirm" name="password_confirmation" required
                                    class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="••••••••">
                                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                    <i data-lucide="lock" class="w-4 h-4 text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            {{ __('Register') }}
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                        </button>

                        <!-- Login Link -->
                        <p class="mt-4 text-center text-sm text-gray-600 dark:text-neutral-400">
                            {{ __('Already have an account?') }}
                            <a class="text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500"
                                href="{{ route('login') }}">
                                {{ __('Login here') }}
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
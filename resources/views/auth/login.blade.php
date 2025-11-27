<x-guest-layout>
    <!-- Logo y título DarkTasks -->
    <div class="flex flex-col items-center mb-6">
        <img src="{{ asset('images/DarkTasks-logo.png') }}" alt="DarkTasks Logo" class="h-20 w-20 mb-3">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">DarkTasks</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Inicia sesión para continuar</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email"
                class="block mt-1 w-full dark:bg-gray-700 dark:text-white dark:border-gray-600"
                type="email"
                name="email"
                :value="old('email')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password"
                class="block mt-1 w-full dark:bg-gray-700 dark:text-white dark:border-gray-600"
                type="password"
                name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me"
                   type="checkbox"
                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                   name="remember">
            <label for="remember_me" class="ml-2 text-sm text-gray-600 dark:text-gray-300">
                {{ __('Remember me') }}
            </label>
        </div>

        <div class="flex items-center justify-between">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200"
                   href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

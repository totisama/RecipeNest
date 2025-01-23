<x-site-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="w-full sm:max-w-md mx-auto mt-10 px-8 py-6 bg-white shadow-xl rounded-lg">
        <h1 class="text-2xl font-bold text-center text-[#5B3A1F] mb-6">{{ __('Log in to your account') }}</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full border-[#D4C4B1] rounded-lg shadow-sm" type="email"
                    name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full border-[#D4C4B1] rounded-lg shadow-sm"
                    type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <a class="text-sm text-[#5B3A1F] hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            </div>

            <div class="flex items-center mb-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-[#D4C4B1] text-[#5B3A1F]">
                    <span class="ms-2 text-sm text-[#5B3A1F]">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-end gap-4 mt-6">
                <a class="text-sm text-[#5B3A1F] hover:underline" href="{{ route('register') }}">
                    {{ __('Dont have an account?') }}
                </a>
                <x-button type="submit" mode="primary">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </div>
</x-site-layout>

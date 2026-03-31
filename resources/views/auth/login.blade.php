<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="text-slate-900">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="!text-slate-800 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full !border-slate-300 !bg-white !text-slate-900 placeholder:!text-slate-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="!text-slate-800 font-semibold" />

            <x-text-input id="password" class="block mt-1 w-full !border-slate-300 !bg-white !text-slate-900"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-lime-600 shadow-sm focus:ring-lime-500" name="remember">
                <span class="ms-2 text-sm text-slate-700">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-slate-700 hover:text-slate-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button
                type="submit"
                class="ms-3 inline-flex items-center rounded-md border border-lime-700 bg-lime-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-lime-500 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2"
                style="background:#65a30d;color:#ffffff;border:1px solid #4d7c0f;min-width:96px;justify-content:center;"
            >
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</x-guest-layout>

<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- ********* إضافة زر Google Socialite في الأعلى ********* --}}
    <div class="mb-6">
        <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
            {{-- يمكنك إضافة أيقونة Google هنا (مثل SVG) --}}
            <svg class="w-5 h-5 mr-3" viewBox="0 0 48 48">
                <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                <path fill="#FF3D00" d="M6.306,14.691l6.096,3.753C14.15,16.279,15,16.5,16,16.5c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,2.109,0.384,4.14,1.115,6.012h3.916c-0.297-1.464-0.457-2.986-0.457-4.52C8.574,21.054,10.158,17.43,12.723,14.691z"/>
                <path fill="#4CAF50" d="M11.115,36.012C14.85,39.068,19.347,40.8,24,40.8c5.445,0,10.686-2.09,14.621-5.643l-5.759-4.475c-2.484,2.576-6.048,4.118-9.862,4.118c-3.791,0-7.387-1.573-9.98-4.148h-4.008C7.526,35.03,11.115,36.012,11.115,36.012z"/>
                <path fill="#1976D2" d="M20.826,17.151c1.868,0,3.585,0.724,4.908,1.905l6.095,3.753c-1.425,1.258-3.15,1.967-4.908,1.967c-3.791,0-7.387-1.573-9.98-4.148h-4.008c2.617-3.92,6.44-6.397,10.743-6.397z"/>
            </svg>
            {{ __('Continue with Google') }}
        </a>
    </div>

    {{-- ********* فاصل "أو" (OR separator) ********* --}}
    <div class="flex items-center justify-center my-6">
        <div class="flex-grow border-t border-gray-300"></div>
        <span class="flex-shrink mx-4 text-gray-500 text-sm font-medium">
            {{ __('OR') }}
        </span>
        <div class="flex-grow border-t border-gray-300"></div>
    </div>

    {{-- ********* نموذج تسجيل الدخول التقليدي ********* --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        {{-- ********* مجموعة الأزرار والروابط السفلية ********* --}}
        <div class="flex items-center justify-between mt-6">
            <div class="flex space-x-4 text-sm">
                @if (Route::has('password.request'))
                    <a class="underline text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="underline text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Register') }}
                    </a>
                @endif
            </div>

            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<x-guest-layout>
    <x-subpages.auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-miscs.application-logo class="w-20 h-20 fill-current" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-session.auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-session.auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-forms.label for="email" :value="__('Email')" />

                <x-forms.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-buttons.button>
                    {{ __('Email Password Reset Link') }}
                </x-buttons.button>
            </div>
        </form>
    </x-subpages.auth-card>
</x-guest-layout>

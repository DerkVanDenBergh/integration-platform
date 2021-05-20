<x-guest-layout>
    <x-subpages.auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-miscs.application-logo class="w-20 h-20 fill-current" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-session.auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-forms.label for="email" :value="__('Email')" />

                <x-forms.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-forms.label for="password" :value="__('Password')" />

                <x-forms.input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-forms.label for="password_confirmation" :value="__('Confirm Password')" />

                <x-forms.input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-buttons.button>
                    {{ __('Reset Password') }}
                </x-buttons.button>
            </div>
        </form>
    </x-subpages.auth-card>
</x-guest-layout>

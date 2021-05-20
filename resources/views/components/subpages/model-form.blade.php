<div class="py-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
        <!-- Session Status -->
        <x-session.auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-session.auth-validation-errors class="mb-4" :errors="$errors" />

        @if($header ?? false)
            <h2 class="font-semibold text-l text-green-400 leading-tight pb-3">
                {{ $header }}
            </h2>
        @endif

        <form method="POST" action="{{ $action }}">
            @csrf

            {{ $method }}

            <div class="grid grid-cols-4 gap-4">
                {{ $fields }}
            </div>


            <div class="flex items-center justify-end">
                <x-buttons.button class="ml-3">
                    {{ __('Save') }}
                </x-buttons.button>
            </div>
        </form>
    </div>
</div>
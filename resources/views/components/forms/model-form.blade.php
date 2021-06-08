<!-- Session Status -->
<x-session.auth-session-status class="mb-4" :status="session('status')" />

<!-- Validation Errors -->
<x-session.auth-validation-errors class="mb-4" :errors="$errors" />

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
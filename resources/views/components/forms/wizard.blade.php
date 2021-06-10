<!-- Session Status -->
<x-session.auth-session-status class="mb-4" :status="session('status')" />

<!-- Validation Errors -->
<x-session.auth-validation-errors class="mb-4" :errors="$errors" />

<form method="POST" action="{{ $action }}">
    @csrf

    <div class="grid grid-cols-4 gap-4">

        <x-forms.components.attribute :span="__(2)" :type="__('select')" :label="__($header ?? 'What would you like to do?')" :name="__('option')" :optionValue="$value" :optionLabel="$label" :options="$options" :required="__(true)"/>

    </div>


    <div class="flex items-center justify-end">
        <x-buttons.button class="ml-3">
            {{ __('Next') }}
        </x-buttons.button>
    </div>
</form>
@if($fields->count() > 0)

    <div class="px-2">
        <form method="POST" action="{{ $action ?? ''}}">
            @csrf
            
            <!-- Session Status -->
            <x-session.auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-session.auth-validation-errors class="mb-4" :errors="$errors" />

            @foreach ($fields as $field)
                <x-forms.components.data-model-field :mapping="$mapping" :availableFields="$availableFields" :field="$field"/>
            @endforeach
        

            <div class="flex items-center justify-end">
                <x-buttons.button class="ml-3">
                    {{ __('Save') }}
                </x-buttons.button>
            </div>
        </form>
    </div>
    
@else
    <x-alerts.empty/>
@endif


@if($fields->count() > 0)
    <div class="px-2">
        @if($form ?? false)
            <form method="POST" action="{{ $action ?? ''}}">
                @csrf
                
                <!-- Session Status -->
                <x-session.auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-session.auth-validation-errors class="mb-4" :errors="$errors" />

                @foreach ($fields as $field)
                    <x-subpages.components.model-field-form :mapping="$mapping" :availableFields="$availableFields" :field="$field"></x-subpages.components.model-field-form>
                @endforeach
            

                <div class="flex items-center justify-end">
                    <x-buttons.button class="ml-3">
                        {{ __('Save') }}
                    </x-buttons.button>
                </div>
            </form>
        @else
            @foreach ($fields as $field)
                <x-subpages.components.model-field :mapping="$mapping ?? ''" :mappingFields="$mappingFields ?? ''" :field="$field" :showEdit="$showEdit" :showDelete="$showDelete" :resource="$resource ?? ''"></x-subpages.components.model-field>
            @endforeach
        @endif
    </div>
    
@else
    <x-alerts.model-empty></x-alerts.model-empty>
@endif
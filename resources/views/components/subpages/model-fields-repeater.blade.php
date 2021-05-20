@if($fields->count() > 0)
    <div class="px-2">
        @if($form ?? false)
            <form method="POST" action="{{ $action ?? ''}}">
                @csrf

                @foreach ($fields as $field)
                    <x-subpages.model-field-form :mapping="$mapping" :availableFields="$availableFields" :field="$field"></x-subpages.model-field-form>
                @endforeach
            

                <div class="flex items-center justify-end">
                    <x-buttons.button class="ml-3">
                        {{ __('Save') }}
                    </x-buttons.button>
                </div>
            </form>
        @else
            @foreach ($fields as $field)
                <x-subpages.model-field :mapping="$mapping ?? ''" :mappingFields="$mappingFields ?? ''" :field="$field" :showEdit="$showEdit" :showDelete="$showDelete" :resource="$resource ?? ''"></x-subpages.model-field>
            @endforeach
        @endif
    </div>
    
@else
    <x-alerts.model-empty></x-alerts.model-empty>
@endif
<x-app-layout>
    
    <x-slot name="header">
        {{ __($route->title . ' - view') }}
    </x-slot>

    <x-subpages.card :header="__('Mapping')">
        <x-slot name="content">
            <x-subpages.components.model-fields-repeater 
                :availableFields="$availableFields"
                :form="__(true)"
                :fields="$fields" 
                :mapping="$mapping">
            
            </x-subpages.components.model-fields-repeater>
        </x-slot>
    </x-subpages.card>

</x-app-layout>

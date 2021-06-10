<x-app-layout>
    
    <x-slot name="header">
        {{ __($processable->title . ' - view') }}
    </x-slot>

    <x-subpages.card :header="__('Mapping')">

        <x-slot name="content">

            <x-forms.data-model-form :availableFields="$availableFields" :form="__(true)" :fields="$fields" :mapping="$mapping" />

        </x-slot>

    </x-subpages.card>

</x-app-layout>

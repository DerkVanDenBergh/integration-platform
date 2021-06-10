<x-app-layout>
    
    <x-slot name="header">
        {{ __('Endpoint - create') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-forms.wizard :action="__('/connections/' . $connection . '/endpoints/create')" :value="__('option')" :label="__('label')" :options="$options"/>

        </x-slot>

    </x-subpages.card>

</x-app-layout>
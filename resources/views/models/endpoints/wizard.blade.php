<x-app-layout>
    
    <x-slot name="header">
        {{ __('Endpoint - create') }}
    </x-slot>

    <x-wizard :action="__('/connections/' . $connection . '/endpoints/create')" :value="__('option')" :label="__('label')" :options="$options"></x-wizard>

</x-app-layout>
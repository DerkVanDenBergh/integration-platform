<x-app-layout>
    
    <x-slot name="header">
        {{ __('Endpoint - create') }}
    </x-slot>

    <x-subpages.wizard :action="__('/connections/' . $connection . '/endpoints/create')" :value="__('option')" :label="__('label')" :options="$options"></x-subpages.wizard>

</x-app-layout>
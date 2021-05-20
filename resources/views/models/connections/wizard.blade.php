<x-app-layout>
    
    <x-slot name="header">
        {{ __('Connection - create') }}
    </x-slot>

    <x-subpages.wizard :action="__('/connections/create')" :value="__('option')" :label="__('label')" :options="$options"></x-subpages.wizard>

</x-app-layout>
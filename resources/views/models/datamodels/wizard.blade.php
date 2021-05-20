<x-app-layout>
    
    <x-slot name="header">
        {{ __('Model - create') }}
    </x-slot>

    <x-subpages.wizard :action="__('/models/create')" :value="__('option')" :label="__('label')" :options="$options"></x-subpages.wizard>

</x-app-layout>
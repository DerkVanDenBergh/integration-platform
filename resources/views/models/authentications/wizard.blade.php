<x-app-layout>
    
    <x-slot name="header">
        {{ __('Authentication - create') }}
    </x-slot>

    <x-subpages.wizard :action="__('/connections/' . $connection . '/authentications/create')" :value="__('option')" :label="__('label')" :options="$options"></x-subpages.wizard>

</x-app-layout>
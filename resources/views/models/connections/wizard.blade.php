<x-app-layout>
    
    <x-slot name="header">
        {{ __('Connection - create') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-forms.wizard :action="__('/connections/create')" :value="__('option')" :label="__('label')" :options="$options"></x-forms.wizard>

        </x-slot>

    </x-subpages.card>
    
</x-app-layout>
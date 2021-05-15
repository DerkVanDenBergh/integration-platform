<x-app-layout>
    
    <x-slot name="header">
        {{ __($endpoint->title . ' - change model') }}
    </x-slot>

    <x-subpages.wizard :header="__('Which model would you like to use?')" :action="__('/endpoints/' . $endpoint->id . '/model')" :value="__('id')" :label="__('title')" :options="$models"></x-subpages.wizard>

</x-app-layout>
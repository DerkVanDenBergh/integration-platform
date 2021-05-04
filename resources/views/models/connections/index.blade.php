<x-app-layout>

    <x-slot name="header">
        {{ __('Connections') }}
    </x-slot>

    <x-model-table :fields="array('title')" :list="$connections" :resource="__('connections')" :showEdit="__(false)">

        <x-slot name="headers">
            <th class="w-3/4 py-2">Name</th>
            <th class="w-1/4 py-2">Actions</th>
        </x-slot>
    
    </x-model-table>

</x-app-layout>

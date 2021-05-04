<x-app-layout>

    <x-slot name="header">
        {{ __('Connections') }}
    </x-slot>

    <x-model-table :fields="array('title', 'type', 'connection_name')" :list="$authentications" :resource="__('authentications')" :hideView="__(true)">
        <x-slot name="headers">
            <th class="w-1/4 py-2">Title</th>
            <th class="w-1/4 py-2">Type</th>
            <th class="w-1/4 py-2">Connection</th>
            <th class="w-1/4 py-2">Actions</th>
        </x-slot>
    </x-model-table>

</x-app-layout>
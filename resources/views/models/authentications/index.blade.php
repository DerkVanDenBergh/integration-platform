<x-app-layout>

    <x-slot name="header">
        {{ __('Authentications') }}
    </x-slot>

    <x-subpages.model-table :fields="array('title', 'type', 'connection_name')" :list="$authentications" :resource="__('authentications')" :showView="__(false)">
        <x-slot name="headers">
            <th class="w-1/4 py-2">Title</th>
            <th class="w-1/4 py-2">Type</th>
            <th class="w-1/4 py-2">Connection</th>
            <th class="w-1/4 py-2">Actions</th>
        </x-slot>
    </x-subpages.model-table>

</x-app-layout>
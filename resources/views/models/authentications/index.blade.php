<x-app-layout>

    <x-slot name="header">
        {{ __('Authentications') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-tables.model-table :fields="array('title', 'type', 'connection_name')" :list="$authentications" :resource="__('authentications')" :showView="__(false)" :showCreate="__(false)">
                <x-slot name="headers">
                    <th class="w-1/4 py-2">Title</th>
                    <th class="w-1/4 py-2">Type</th>
                    <th class="w-1/4 py-2">Connection</th>
                    <th class="w-1/4 py-2">Actions</th>
                </x-slot>
            </x-tables.model-table>

        </x-slot>

    </x-subpages.card>

</x-app-layout>
<x-app-layout>

    <x-slot name="header">
        {{ __('Connections') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-tables.model-table :fields="array('title')" :list="$connections" :resource="__('connections')" :showEdit="__(false)">

                <x-slot name="headers">
                    <th class="w-3/4 py-2">Name</th>
                    <th class="w-1/4 py-2">Actions</th>
                </x-slot>
            
            </x-tables.model-table>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

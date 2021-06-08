<x-app-layout>

    <x-slot name="header">
        {{ __('Log entries') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-tables.model-table :fields="array('level', 'title', 'created_at')" :list="$logs" :resource="__('logs')" :showEdit="__(false)" :showDelete="__(false)" :showCreate="__(false)">

                <x-slot name="headers">
                    <th class="w-1/16 py-2">Level</th>
                    <th class="w-2/4 py-2">Title</th>
                    <th class="w-1/4 py-2">Date</th>
                    <th class="w-1/16 py-2">Actions</th>
                </x-slot>
            
            </x-tables.model-table>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

<x-app-layout>

    <x-slot name="header">
        {{ __('Routes') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-tables.model-table :fields="array('title', 'slug', 'active')" :list="$routes" :resource="__('routes')" :showEdit="__(false)">

                <x-slot name="headers">
                    <th class="w-2/4 py-2">Name</th>
                    <th class="w-1/4 py-2">URL</th>
                    <th class="w-1/8 py-2">Active</th>
                    <th class="w-1/8 py-2">Actions</th>
                </x-slot>
            
            </x-tables.model-table>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        {{ __('Users') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-tables.model-table :fields="array('name', 'email')" :list="$users" :resource="__('users')">

                <x-slot name="headers">
                    <th class="w-3/8 py-2">Name</th>
                    <th class="w-3/8 py-2">E-mail</th>
                    <th class="w-1/4 py-2">Actions</th>
                </x-slot>
            
            </x-tables.model-table>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

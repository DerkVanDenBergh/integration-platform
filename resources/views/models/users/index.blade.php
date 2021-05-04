<x-app-layout>
    <x-slot name="header">
        {{ __('Users') }}
    </x-slot>

    <x-model-table :fields="array('name', 'email')" :list="$users" :resource="__('users')" :showEdit="__(false)">

        <x-slot name="headers">
            <th class="w-3/8 py-2">Name</th>
            <th class="w-3/8 py-2">E-mail</th>
            <th class="w-1/4 py-2">Actions</th>
        </x-slot>
    
    </x-model-table>

</x-app-layout>

<x-app-layout>
    
    <x-slot name="header">
        {{ __('User roles') }}
    </x-slot>

    <x-subpages.model-table :fields="array('title')" :list="$roles" :resource="__('roles')">

        <x-slot name="headers">
            <th class="w-3/4 py-2">Role</th>
            <th class="w-1/4 py-2">Actions</th>
        </x-slot>
    
    </x-subpages.model-table>

</x-app-layout>

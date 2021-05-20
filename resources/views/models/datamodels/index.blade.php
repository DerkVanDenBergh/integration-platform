<x-app-layout>

    <x-slot name="header">
        {{ __('Models') }}
    </x-slot>

    <x-subpages.model-table :fields="array('title')" :list="$models" :resource="__('models')" :showEdit="__(false)">

        <x-slot name="headers">
            <th class="w-3/4 py-2">Name</th>
            <th class="w-1/4 py-2">Actions</th>
        </x-slot>
    
    </x-subpages.model-table>

</x-app-layout>

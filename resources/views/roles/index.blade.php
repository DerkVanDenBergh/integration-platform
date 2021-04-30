<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User roles') }}
        </h2>
    </x-slot>

    <div class="py-12">

            @php
                $fields = array("title");
                $resource = "roles";
            @endphp

            <x-model-index-table :fields="$fields" :list="$roles" :resource="$resource">

                <x-slot name="headers">
                    <th class="w-3/4 py-2">Role</th>
                    <th class="w-1/4 py-2">Actions</th>
                </x-slot>
            
            </x-model-index-table>

    </div>
</x-app-layout>

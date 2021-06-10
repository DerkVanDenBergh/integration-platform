<x-app-layout>
    
    <x-slot name="header">
        {{ __($connection->title . ' - view') }}
    </x-slot>

    <x-subpages.card :header="__('Details')">
    
        <x-slot name="content">

            <x-details.model-details  :model="$connection" :resource="__('connections')">

                <x-slot name="fields">

                    <x-details.components.attribute :span="__(2)" :type="__('text')" :label="__('Name')" :name="__('title')" :value="$connection->title"/>

                    <x-details.components.attribute :span="__(2)" :type="__('text')" :label="__('Base URL')" :name="__('base_url')" :value="$connection->base_url"/>

                    <x-details.components.attribute :span="__(4)" :type="__('text')" :label="__('Description')" :name="__('description')" :value="$connection->description"/>
                    
                </x-slot>
            
            </x-details.model-details>

        </x-slot>

    </x-subpages.card>

    
    <x-subpages.card :header="__('Authentications')">
    
        <x-slot name="content">

            <x-tables.model-table :fields="array('title', 'type')" :list="$connection->authentications()->get()" :nestedResource="__('connections/' . $connection->id . '/authentications')" :resource="__('authentications')" :showView="__(false)">
                <x-slot name="headers">
                    <th class="w-3/8 py-2">Title</th>
                    <th class="w-3/8 py-2">Type</th>
                    <th class="w-1/4 py-2">Actions</th>
                </x-slot>
            </x-tables.model-table>

        </x-slot>

    </x-subpages.card>


    <x-subpages.card :header="__('Endpoints')">
    
        <x-slot name="content">

            <x-tables.model-table :header="__('Endpoints')" :fields="array('title', 'endpoint', 'protocol', 'method')" :list="$connection->endpoints()->get()" :nestedResource="__('connections/' . $connection->id . '/endpoints')" :resource="__('endpoints')" :showEdit="__(false)">
                <x-slot name="headers">
                    <th class="w-3/16 py-2">Title</th>
                    <th class="w-3/16 py-2">Endpoint</th>
                    <th class="w-3/16 py-2">Protocol</th>
                    <th class="w-3/16 py-2">Method</th>
                    <th class="w-1/4 py-2">Actions</th>
                </x-slot>
            </x-tables.model-table>

        </x-slot>

    </x-subpages.card>

    

</x-app-layout>

<x-app-layout>
    
    <x-slot name="header">
        {{ __($connection->title . ' - view') }}
    </x-slot>

    <x-model-view :header="__('Details')" :model="$connection" :resource="__('connections')">

        <x-slot name="fields">

            <div class="col-span-2">
                <x-label for="title" :value="__('Name')" />

                <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $connection->title }}" required disabled autofocus />
            </div>

            <div class="col-span-2">
                <x-label for="base_url" :value="__('Base URL')" />

                <x-input id="base_url" class="block mt-1 w-full" type="text" name="base_url" value="{{ $connection->base_url }}" required disabled autofocus />
            </div>
            
            <div class="col-span-4">
                <x-label for="description" :value="__('Description')" />

                <x-input id="description" class="block mt-1 w-full" type="text" name="description" value="{{ $connection->description }}" disabled autofocus />
            </div>

        </x-slot>
    
    </x-model-view>

    <x-model-table :header="__('Authentications')" :fields="array('title', 'type')" :list="$authentications" :nestedResource="__('connections/' . $connection->id . '/authentications')" :resource="__('authentications')" :hideView="__(true)">
        <x-slot name="headers">
            <th class="w-3/8 py-2">Title</th>
            <th class="w-3/8 py-2">Type</th>
            <th class="w-1/4 py-2">Actions</th>
        </x-slot>
    </x-model-table>

    <x-model-table :header="__('Endpoints')" :fields="array('endpoint', 'protocol', 'method')" :list="$endpoints" :resource="__('connections/' . $connection->id . '/endpoints')" :hideEdit="__(true)">
        <x-slot name="headers">
            <th class="w-1/4 py-2">Endpoint</th>
            <th class="w-1/4 py-2">Protocol</th>
            <th class="w-1/4 py-2">Method</th>
            <th class="w-1/4 py-2">Actions</th>
        </x-slot>
    </x-model-table>

</x-app-layout>

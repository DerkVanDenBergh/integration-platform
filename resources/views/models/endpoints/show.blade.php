<x-app-layout>
    
    <x-slot name="header">
        {{ __($connection->title . ' - ' . $endpoint->title . ' - view') }}
    </x-slot>

    <x-subpages.card :header="__('Details')">
    
        <x-slot name="content">

            <x-details.model-details :model="$endpoint" :resource="__('endpoints')">

                <x-slot name="fields">

                    <x-details.components.attribute :span="__(2)" :type="__('text')" :label="__('Name')" :name="__('title')" :value="$endpoint->title"/>

                    <x-details.components.attribute :span="__(2)" :type="__('text')" :label="__('Protocol')" :name="__('protocol')" :value="$endpoint->protocol"/>

                    <x-details.components.attribute :span="__(2)" :type="__('text')" :label="__('Endpoint')" :name="__('endpoint')" :value="$endpoint->endpoint"/>
                    
                    @if($endpoint->port)

                        <x-details.components.attribute :span="__(1)" :type="__('integer')" :label="__('Port')" :name="__('port')" :value="$endpoint->port"/>

                        <x-details.components.attribute :span="__(1)" :type="__('text')" :label="__('Method')" :name="__('method')" :value="$endpoint->method"/>

                    @else

                        <x-details.components.attribute :span="__(2)" :type="__('text')" :label="__('Method')" :name="__('method')" :value="$endpoint->method"/>

                    @endif

                    <x-details.components.attribute :span="__(4)" :type="__('select')" :label="__('Authentication')" :name="__('authentication_id')" :optionValue="__('id')" :optionLabel="__('title')" :options="$authentications" :selected="$endpoint->authentication_id"/>

                </x-slot>
            
            </x-details.model-details>

        </x-slot>

    </x-subpages.card>

    <x-subpages.card :header="__('Model')">
    
        <x-slot name="content">

            <x-views.data-model-view :fields="$fields" :showEdit="__(false)" :showDelete="__(false)" :showCreate="__(false)" :showEndpointActions="__(true)" :endpoint="$endpoint"/>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

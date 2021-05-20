<x-app-layout>
    
    <x-slot name="header">
        {{ __($connection->title . ' - ' . $endpoint->title . ' - view') }}
    </x-slot>

    <x-subpages.model-view :header="__('Details')" :model="$endpoint" :resource="__('endpoints')">

        <x-slot name="fields">

            <div class="col-span-2">
                <x-forms.label for="title" :value="__('Name')" />

                <x-forms.input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $endpoint->title }}" required disabled autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="protocol" :value="__('Protocol')" />

                <x-forms.input id="protocol" class="block mt-1 w-full" type="text" name="protocol" value="{{ $endpoint->protocol }}" required disabled autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="endpoint" :value="__('Endpoint')" />

                <x-forms.input id="endpoint" class="block mt-1 w-full" type="text" name="endpoint" value="{{ $endpoint->endpoint }}" required disabled autofocus />
            </div>
            
            @if($endpoint->port)
                <div class="col-span-1">
                    <x-forms.label for="port" :value="__('Port')" />

                    <x-forms.input id="port" class="block mt-1 w-full" type="integer" name="port" value="{{ $endpoint->port }}" disabled autofocus />
                </div>

                <div class="col-span-1">
                    <x-forms.label for="method" :value="__('Method')" />

                    <x-forms.input id="method" class="block mt-1 w-full" type="text" name="method" value="{{ $endpoint->method }}" disabled autofocus />
                </div>
            @else
                <div class="col-span-2">
                    <x-forms.label for="method" :value="__('Method')" />

                    <x-forms.input id="method" class="block mt-1 w-full" type="text" name="method" value="{{ $endpoint->method }}" disabled autofocus />
                </div>
            @endif

            <div class="col-span-4">
                <x-forms.label for="authentication_id" :value="__('Authentication')" />

                <x-forms.select id="authentication_id" :value="__('id')" :label="__('title')" :options="$authentications" :selected="$endpoint->authentication_id" class="block mt-1 w-full" name="authentication_id" required disabled autofocus />
            </div>


        </x-slot>
    
    </x-subpages.model-view>

    <x-subpages.model-fields :header="__('Model')" :fields="$fields" :showEdit="__(false)" :showDelete="__(false)" :showCreate="__(false)" :showEndpointActions="__(true)" :endpoint="$endpoint"></x-subpages.model-fields>

</x-app-layout>

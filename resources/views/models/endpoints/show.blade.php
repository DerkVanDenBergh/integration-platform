<x-app-layout>
    
    <x-slot name="header">
        {{ __($connection->title . ' - ' . $endpoint->title . ' - view') }}
    </x-slot>

    <x-model-view :header="__('Details')" :model="$endpoint" :resource="__('endpoints')">

        <x-slot name="fields">

            <div class="col-span-2">
                <x-label for="title" :value="__('Name')" />

                <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $endpoint->title }}" required disabled autofocus />
            </div>

            <div class="col-span-2">
                <x-label for="protocol" :value="__('Protocol')" />

                <x-input id="protocol" class="block mt-1 w-full" type="text" name="protocol" value="{{ $endpoint->protocol }}" required disabled autofocus />
            </div>

            <div class="col-span-2">
                <x-label for="endpoint" :value="__('Endpoint')" />

                <x-input id="endpoint" class="block mt-1 w-full" type="text" name="endpoint" value="{{ $endpoint->endpoint }}" required disabled autofocus />
            </div>
            
            @if($endpoint->port)
                <div class="col-span-1">
                    <x-label for="port" :value="__('Port')" />

                    <x-input id="port" class="block mt-1 w-full" type="integer" name="port" value="{{ $endpoint->port }}" disabled autofocus />
                </div>

                <div class="col-span-1">
                    <x-label for="method" :value="__('Method')" />

                    <x-input id="method" class="block mt-1 w-full" type="text" name="method" value="{{ $endpoint->method }}" disabled autofocus />
                </div>
            @else
                <div class="col-span-2">
                    <x-label for="method" :value="__('Method')" />

                    <x-input id="method" class="block mt-1 w-full" type="text" name="method" value="{{ $endpoint->method }}" disabled autofocus />
                </div>
            @endif

        </x-slot>
    
    </x-model-view>

</x-app-layout>

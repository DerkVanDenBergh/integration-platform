<x-app-layout>
    <x-slot name="header">
        {{ __($endpoint->title . ' - edit') }}
    </x-slot>

    <x-subpages.model-form :action="__('/endpoints/' . $endpoint->id)">

        <x-slot name="method">
            <input name="_method" type="hidden" value="PUT">
        </x-slot>

        <x-slot name="fields">

            <div class="col-span-4">
                <x-forms.input id="protocol" type="hidden" name="protocol" value="{{ $endpoint->protocol }}" required autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="title" :value="__('Name')" />

                <x-forms.input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $endpoint->title}}" required autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="authentication_id" :value="__('Authentication')" />

                <x-forms.select id="authentication_id" :value="__('id')" :label="__('title')" :selected="$endpoint->authentication_id" :options="$authentications" class="block mt-1 w-full" name="authentication_id" autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="endpoint" :value="__('Endpoint')" />

                <x-forms.input id="endpoint" class="block mt-1 w-full" type="text" name="endpoint" value="{{ $endpoint->endpoint}}" required autofocus />
            </div>

            <div class="col-span-1">
                <x-forms.label for="port" :value="__('Port')" />

                <x-forms.input id="port" class="block mt-1 w-full" type="number" name="port" value="{{ $endpoint->port }}" required autofocus />
            </div>

            <div class="col-span-1">
                <x-forms.label for="method" :value="__('Method')" />

                <x-forms.select id="method" :value="__('option')" :label="__('option')" :selected="$endpoint->method" :options="$methods" class="block mt-1 w-full" name="method" required autofocus />
            </div>
            
        </x-slot>
    
    </x-subpages.model-form>

</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        {{ __('TCP endpoint - create') }}
    </x-slot>

    <x-subpages.model-form :action="__('/connections/' . $connection . '/endpoints')">

        <x-slot name="method">
            <input name="_method" type="hidden" value="POST">
        </x-slot>

        <x-slot name="fields">

            <div class="col-span-4">
                <x-forms.input id="protocol" type="hidden" name="protocol" value="{{ $type }}" required autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="title" :value="__('Name')" />

                <x-forms.input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="authentication_id" :value="__('Authentication')" />

                <x-forms.select id="authentication_id" :value="__('id')" :label="__('title')" :options="$authentications" class="block mt-1 w-full" name="authentication_id" required autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="endpoint" :value="__('Endpoint')" />

                <x-forms.input id="endpoint" class="block mt-1 w-full" type="text" name="endpoint" :value="old('endpoint')" required autofocus />
            </div>

            <div class="col-span-1">
                <x-forms.label for="port" :value="__('Port')" />

                <x-forms.input id="port" class="block mt-1 w-full" type="number" name="port" :value="old('port')" required autofocus />
            </div>

            <div class="col-span-1">
                <x-forms.label for="method" :value="__('Method')" />

                <x-forms.select id="method" :value="__('option')" :label="__('option')" :options="$methods" class="block mt-1 w-full" name="method" required autofocus />
            </div>

            
            
        </x-slot>
    
    </x-subpages.model-form>

</x-app-layout>

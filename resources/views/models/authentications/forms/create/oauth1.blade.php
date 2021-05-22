<x-app-layout>
    <x-slot name="header">
        {{ __('Authentication - create') }}
    </x-slot>

    <x-subpages.model-form :action="__('/connections/' . $connection . '/authentications')">

        <x-slot name="method">
            <input name="_method" type="hidden" value="POST">
        </x-slot>

        <x-slot name="fields">

            <div class="col-span-4">
                <x-forms.input id="type" type="hidden" name="type" value="{{ $type }}" required autofocus />
            </div>

            <div class="col-span-4">
                <x-forms.label for="title" :value="__('Name')" />

                <x-forms.input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
            </div>
            
            <div class="col-span-2">
                <x-forms.label for="oauth1_consumer_key" :value="__('Consumer key')" />

                <x-forms.input id="oauth1_consumer_key" class="block mt-1 w-full" type="text" name="oauth1_consumer_key" :value="old('oauth1_consumer_key')" required autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="oauth1_consumer_secret" :value="__('Consumer key secret')" />

                <x-forms.input id="oauth1_consumer_secret" class="block mt-1 w-full" type="text" name="oauth1_consumer_secret" :value="old('oauth1_consumer_secret')" required autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="oauth1_token" :value="__('Token')" />

                <x-forms.input id="oauth1_token" class="block mt-1 w-full" type="text" name="oauth1_token" :value="old('oauth1_token')" required autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="oauth1_token_secret" :value="__('Token secret')" />

                <x-forms.input id="oauth1_token_secret" class="block mt-1 w-full" type="text" name="oauth1_token_secret" :value="old('oauth1_token_secret')" required autofocus />
            </div>
            
        </x-slot>
    
    </x-subpages.model-form>

</x-app-layout>

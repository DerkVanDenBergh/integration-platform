<x-app-layout>
    <x-slot name="header">
        {{ __('Authentication - create') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-forms.model-form :action="__('/connections/' . $connection . '/authentications')">

                <x-slot name="method">
                    <input name="_method" type="hidden" value="POST">
                </x-slot>

                <x-slot name="fields">

                    <x-forms.components.attribute :span="__(4)" :type="__('hidden')" :name="__('type')" :value="$type" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(4)" :type="__('text')" :label="__('Name')" :name="__('title')" :value="old('title')" :required="__(true)"/>

                    @if(strtolower($type) == 'basic')

                        <x-forms.components.attribute :span="__(2)" :type="__('text')" :label="__('Username')" :name="__('username')" :value="old('username')" :required="__(true)"/>

                        <x-forms.components.attribute :span="__(2)" :type="__('password')" :label="__('Password')" :name="__('password')" :value="old('password')" :required="__(true)"/>

                    @endif

                    @if(strtolower($type) == 'token')

                        <x-forms.components.attribute :span="__(4)" :type="__('password')" :label="__('API token')" :name="__('token')" :value="old('token')" :required="__(true)"/>

                    @endif

                    @if(strtolower($type) == 'oauth1')

                        <x-forms.components.attribute :span="__(2)" :type="__('password')" :label="__('Consumer key')" :name="__('oauth1_consumer_key')" :value="old('oauth1_consumer_key')" :required="__(true)"/>

                        <x-forms.components.attribute :span="__(2)" :type="__('password')" :label="__('Consumer key secret')" :name="__('oauth1_consumer_secret')" :value="old('oauth1_consumer_secret')" :required="__(true)"/>
                        
                        <x-forms.components.attribute :span="__(2)" :type="__('password')" :label="__('Token')" :name="__('oauth1_token')" :value="old('oauth1_token')" :required="__(true)"/>
                        
                        <x-forms.components.attribute :span="__(2)" :type="__('password')" :label="__('Token secret')" :name="__('oauth1_token_secret')" :value="old('oauth1_token_secret')" :required="__(true)"/>

                    @endif

                </x-slot>
            
            </x-forms.model-form>

        </x-slot>
    
    </x-forms.model-form>

</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        {{ __($authentication->title . ' - edit') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-forms.model-form :action="__('/authentications/' . $authentication->id)">

                <x-slot name="method">
                    <input name="_method" type="hidden" value="PUT">
                </x-slot>

                <x-slot name="fields">

                    <x-forms.components.attribute :span="__(4)" :type="__('hidden')" :name="__('type')" :value="$authentication->type" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(4)" :type="__('text')" :label="__('Name')" :name="__('title')" :value="$authentication->title" :required="__(true)"/>

                    @if(strtolower($authentication->type) == 'basic')

                        <x-forms.components.attribute :span="__(2)" :type="__('text')" :label="__('Username')" :name="__('username')" :value="$authentication->username" :required="__(true)"/>

                        <x-forms.components.attribute :span="__(2)" :type="__('password')" :label="__('Password')" :name="__('password')" :value="$authentication->password" :required="__(true)"/>

                    @endif

                    @if(strtolower($authentication->type) == 'token')

                        <x-forms.components.attribute :span="__(4)" :type="__('password')" :label="__('API token')" :name="__('token')" :value="$authentication->token" :required="__(true)"/>

                    @endif

                    @if(strtolower($authentication->type) == 'oauth1')

                        <x-forms.components.attribute :span="__(2)" :type="__('password')" :label="__('Consumer key')" :name="__('oauth1_consumer_key')" :value="$authentication->oauth1_consumer_key" :required="__(true)"/>

                        <x-forms.components.attribute :span="__(2)" :type="__('password')" :label="__('Consumer key secret')" :name="__('oauth1_consumer_secret')" :value="$authentication->oauth1_consumer_secret" :required="__(true)"/>
                        
                        <x-forms.components.attribute :span="__(2)" :type="__('password')" :label="__('Token')" :name="__('oauth1_token')" :value="$authentication->oauth1_token" :required="__(true)"/>
                        
                        <x-forms.components.attribute :span="__(2)" :type="__('password')" :label="__('Token secret')" :name="__('oauth1_token_secret')" :value="$authentication->oauth1_token_secret" :required="__(true)"/>

                    @endif

                </x-slot>
            
            </x-forms.model-form>

        </x-slot>
    
    </x-forms.model-form>

</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        {{ __($endpoint->title . ' - edit') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-forms.model-form :action="__('/endpoints/' . $endpoint->id)">

                <x-slot name="method">
                    <input name="_method" type="hidden" value="PUT">
                </x-slot>

                <x-slot name="fields">

                    <x-forms.components.attribute :span="__(4)" :type="__('hidden')" :name="__('protocol')" :value="$endpoint->protocol" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(2)" :type="__('text')" :label="__('Name')" :name="__('title')" :value="$endpoint->title" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(2)" :type="__('select')" :label="__('Authentication')" :name="__('authentication_id')" :optionValue="__('id')" :optionLabel="__('title')" :options="$authentications" :required="__(true)" :selected="$endpoint->authentication_id"/>

                    <x-forms.components.attribute :span="__(2)" :type="__('text')" :label="__('Endpoint')" :name="__('endpoint')" :value="$endpoint->endpoint" :required="__(true)"/>

                    @if(strtolower($endpoint->protocol) == 'tcp')

                        <x-forms.components.attribute :span="__(1)" :type="__('number')" :label="__('Port')" :name="__('port')" :value="$endpoint->port" :required="__(true)"/>
                    
                    @endif

                    <x-forms.components.attribute :span="__(1)" :type="__('select')" :label="__('Method')" :name="__('method')" :optionValue="__('option')" :optionLabel="__('option')" :options="$methods" :required="__(true)" :selected="$endpoint->method"/>
                    
                </x-slot>
    
            </x-forms.model-form>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

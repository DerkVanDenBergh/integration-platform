<x-app-layout>
    <x-slot name="header">
        {{ __('TCP endpoint - create') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-forms.model-form :action="__('/connections/' . $connection . '/endpoints')">

                <x-slot name="method">
                    <input name="_method" type="hidden" value="POST">
                </x-slot>

                <x-slot name="fields">

                    <x-forms.components.attribute :span="__(4)" :type="__('hidden')" :name="__('protocol')" :value="$type" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(2)" :type="__('text')" :label="__('Name')" :name="__('title')" :value="old('title')" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(2)" :type="__('select')" :label="__('Authentication')" :name="__('authentication_id')" :optionValue="__('id')" :optionLabel="__('title')" :options="$authentications" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(2)" :type="__('text')" :label="__('Endpoint')" :name="__('endpoint')" :value="old('endpoint')" :required="__(true)"/>

                    @if(strtolower($type) == 'tcp')

                        <x-forms.components.attribute :span="__(1)" :type="__('number')" :label="__('Port')" :name="__('port')" :value="old('port')" :required="__(true)"/>
                    
                    @endif

                    <x-forms.components.attribute :span="__(1)" :type="__('select')" :label="__('Method')" :name="__('method')" :optionValue="__('option')" :optionLabel="__('option')" :options="$methods" :required="__(true)"/>
                    
                </x-slot>
            
            </x-forms.model-form>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

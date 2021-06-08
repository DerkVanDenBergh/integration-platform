<x-app-layout>
    <x-slot name="header">
        {{ __($connection->title . ' - edit') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">
    
            <x-forms.model-form :action="__('/connections/') . $connection->id">

                <x-slot name="method">
                    <input name="_method" type="hidden" value="PUT">
                </x-slot>

                <x-slot name="fields">

                    <x-forms.components.attribute :span="__(2)" :type="__('text')" :label="__('Name')" :name="__('title')" :value="$connection->title" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(2)" :type="__('text')" :label="__('Base URL')" :name="__('base_url')" :value="$connection->base_url" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(4)" :type="__('text')" :label="__('Description')" :name="__('description')" :value="$connection->description"/>
                    
                </x-slot>
            
            </x-forms.model-form>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

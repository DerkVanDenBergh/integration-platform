<x-app-layout>
    
    <x-slot name="header">
        {{ __('Connection - create') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-forms.model-form :action="__('/connections')">

                <x-slot name="method">
                    <input name="_method" type="hidden" value="POST">
                </x-slot>

                <x-slot name="fields">

                    <x-forms.components.attribute :span="__(2)" :type="__('text')" :label="__('Name')" :name="__('title')" :value="old('title')" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(2)" :type="__('text')" :label="__('Base URL')" :name="__('base_url')" :value="old('base_url')" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(4)" :type="__('text')" :label="__('Description')" :name="__('description')" :value="old('description')"/>

                    @can('manage_templates') 
                        <!-- TODO redirect to /templates after activating this -->

                        <x-forms.components.attribute :span="__(2)" :type="__('checkbox')" :label="__('Connection template')" :name="__('template')"/>
                    @endcan
                    
                </x-slot>
            
            </x-forms.model-form>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

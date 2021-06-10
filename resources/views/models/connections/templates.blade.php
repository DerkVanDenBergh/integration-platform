<x-app-layout>
    
    <x-slot name="header">
        {{ __('Connection - create from template') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-forms.model-form :action="__('/connections/create/template')">

                <x-slot name="method">
                    <input name="_method" type="hidden" value="POST">
                </x-slot>

                <x-slot name="fields">

                    <x-forms.components.attribute :span="__(2)" :type="__('text')" :label="__('Name')" :name="__('title')" :value="old('title')" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(2)" :type="__('select')" :label="__('Template')" :name="__('template_id')" :optionValue="__('id')" :optionLabel="__('title')" :options="$templates" :required="__(true)"/>
                    
                </x-slot>
            
            </x-forms.model-form>
        
        </x-slot>

    </x-subpages.card>

</x-app-layout>

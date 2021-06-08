<x-app-layout>
    
    <x-slot name="header">
        {{ __('Users - create') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-forms.model-form :action="__('/users')">

                <x-slot name="method">
                    <input name="_method" type="hidden" value="POST">
                </x-slot>

                <x-slot name="fields">

                    <x-forms.components.attribute :span="__(2)" :type="__('text')" :label="__('Name')" :name="__('name')" :value="old('name')" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(2)" :type="__('email')" :label="__('E-mail')" :name="__('email')" :value="old('email')" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(4)" :type="__('select')" :label="__('Role')" :name="__('role_id')" :optionValue="__('id')" :optionLabel="__('title')" :options="$roles" :required="__(true)"/>
                    
                </x-slot>
            
            </x-forms.model-form>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

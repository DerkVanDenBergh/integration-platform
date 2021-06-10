<x-app-layout>
    
    <x-slot name="header">
        {{ __('User roles - create') }}
    </x-slot>

    <x-subpages.card :header="__('Mapping')">

        <x-slot name="content">

            <x-forms.model-form :action="__('/roles')">

                <x-slot name="method">
                    <input name="_method" type="hidden" value="POST">
                </x-slot>

                <x-slot name="fields">

                    <x-forms.components.attribute :span="__(2)" :type="__('text')" :label="__('Role name')" :name="__('title')" :value="old('title')" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(1)" :type="__('checkbox')" :label="__('Can manage users')" :name="__('can_manage_users')"/>

                    <x-forms.components.attribute :span="__(1)" :type="__('checkbox')" :label="__('Can manage roles')" :name="__('can_manage_roles')"/>

                    <x-forms.components.attribute :span="__(1)" :type="__('checkbox')" :label="__('Can manage functions')" :name="__('can_manage_functions')"/>

                    <x-forms.components.attribute :span="__(1)" :type="__('checkbox')" :label="__('Can manage templates')" :name="__('can_manage_templates')"/>

                </x-slot>
            
            </x-forms.model-form>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

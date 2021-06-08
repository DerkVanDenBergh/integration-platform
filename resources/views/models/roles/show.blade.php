<x-app-layout>
    
    <x-slot name="header">
        {{ __($role->title . ' - view') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-details.model-details :model="$role" :resource="__('roles')">

                <x-slot name="fields">

                    <x-details.components.attribute :span="__(4)" :type="__('text')" :label="__('Role name')" :name="__('title')" :value="$role->title" :required="__(true)"/>

                    <x-details.components.attribute :span="__(1)" :type="__('checkbox')" :label="__('Can manage users')" :name="__('can_manage_users')" :checked="$role->can_manage_users"/>

                    <x-details.components.attribute :span="__(1)" :type="__('checkbox')" :label="__('Can manage roles')" :name="__('can_manage_roles')" :checked="$role->can_manage_roles"/>

                    <x-details.components.attribute :span="__(1)" :type="__('checkbox')" :label="__('Can manage functions')" :name="__('can_manage_functions')" :checked="$role->can_manage_functions"/>

                    <x-details.components.attribute :span="__(1)" :type="__('checkbox')" :label="__('Can manage templates')" :name="__('can_manage_templates')" :checked="$role->can_manage_templates"/>

                </x-slot>
            
            </x-details.model-details>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

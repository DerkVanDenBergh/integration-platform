<x-app-layout>

    <x-slot name="header">
        {{ __($user->title . ' - view') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-details.model-details :model="$user" :resource="__('users')">

                <x-slot name="fields">

                    <x-details.components.attribute :span="__(2)" :type="__('text')" :label="__('Name')" :name="__('name')" :value="$user->name" />

                    <x-details.components.attribute :span="__(2)" :type="__('email')" :label="__('E-mail')" :name="__('email')" :value="$user->email" />

                    <x-details.components.attribute :span="__(4)" :type="__('select')" :label="__('Role')" :name="__('role_id')" :optionValue="__('id')" :optionLabel="__('title')" :options="$roles" :selected="$user->role_id"/>
                    
                </x-slot>
            
            </x-details.model-details>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

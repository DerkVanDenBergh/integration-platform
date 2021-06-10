<x-app-layout>

    <x-slot name="header">
        {{ __($user->name . ' - edit') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-forms.model-form :action="__('/users/') . $user->id">

                <x-slot name="method">
                    <input name="_method" type="hidden" value="PUT">
                </x-slot>

                <x-slot name="fields">

                    <x-forms.components.attribute :span="__(2)" :type="__('text')" :label="__('Name')" :name="__('name')" :value="$user->name" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(2)" :type="__('email')" :label="__('E-mail')" :name="__('email')" :value="$user->email" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(4)" :type="__('select')" :label="__('Role')" :name="__('role_id')" :optionValue="__('id')" :optionLabel="__('title')" :options="$roles" :required="__(true)" :selected="$user->role_id"/>
                    
                </x-slot>
            
            </x-forms.model-form>

        </x-slot>

    </x-subpages.card>

</x-app-layout>
<x-app-layout>
    
    <x-slot name="header">
        {{ __('Task - create') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-forms.model-form :action="__('/tasks')">

                <x-slot name="method">
                    <input name="_method" type="hidden" value="POST">
                </x-slot>

                <x-slot name="fields">

                    <x-forms.components.attribute :span="__(2)" :type="__('text')" :label="__('Name')" :name="__('title')" :value="old('title')" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(2)" :type="__('number')" :label="__('Execution interval (min)')" :name="__('interval')" :value="old('interval')" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(4)" :type="__('text')" :label="__('Description')" :name="__('description')" :value="old('description')"/>

                </x-slot>
            
            </x-forms.model-form>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

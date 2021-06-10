<x-app-layout>
    
    <x-slot name="header">
        {{ __($field->name . ' - edit') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">

            <x-forms.model-form :action="__('/models/' . $field->model_id . '/fields/' . $field->id)">

                <x-slot name="method">
                    <input name="_method" type="hidden" value="PUT">
                </x-slot>

                <x-slot name="fields">

                    <x-forms.components.attribute :span="__(1)" :type="__('text')" :label="__('Name')" :name="__('name')" :value="$field->name" :required="__(true)"/>

                    <x-forms.components.attribute :span="__(1)" :type="__('select')" :label="__('Node type')" :name="__('node_type')" :optionValue="__('option')" :optionLabel="__('label')" :options="$node_types" :required="__(true)" :selected="$field->node_type"/>

                    <x-forms.components.attribute :span="__(2)" :type="__('select')" :label="__('Data type')" :name="__('data_type')" :optionValue="__('option')" :optionLabel="__('label')" :options="$data_types" :selected="$field->data_type"/>

                    @if(($fields->count() > 1) || $field->parent_id)

                        <x-forms.components.attribute :span="__(4)" :type="__('select')" :label="__('Parent')" :name="__('parent_id')" :optionValue="__('id')" :optionLabel="__('name')" :options="$fields" :selected="$field->parent_id"/>
                    
                    @endif
                    
                </x-slot>
            
            </x-forms.model-form>
        
        </x-slot>

    </x-subpages.card>

</x-app-layout>

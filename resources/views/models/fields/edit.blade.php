<x-app-layout>
    
    <x-slot name="header">
        {{ __($field->name . ' - edit') }}
    </x-slot>

    <x-forms.model-form :action="__('/models/' . $field->model_id . '/fields/' . $field->id)">

        <x-slot name="method">
            <input name="_method" type="hidden" value="PUT">
        </x-slot>

        <x-slot name="fields">

            <div class="col-span-4">
                <x-forms.label for="name" :value="__('Name')" />

                <x-forms.input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $field->name }}" required autofocus />
            </div>
            
            <div class="col-span-2">
                <x-forms.label for="node_type" :value="__('Node type')" />

                <x-forms.select id="node_type" :value="__('option')" :label="__('label')" :selected="$field->node_type" :options="$node_types" class="block mt-1 w-full" name="node_type" required autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="data_type" :value="__('Data type')" />

                <x-forms.select id="data_type" :value="__('option')" :label="__('label')" :selected="$field->data_type" :options="$data_types" class="block mt-1 w-full" name="data_type" required autofocus />
            </div>

            <div class="col-span-4">
                <x-forms.label for="parent_id" :value="__('Parent')" />

                <x-forms.select id="parent_id" :value="__('id')" :label="__('name')" :selected="$field->parent_id" :options="$fields" class="block mt-1 w-full" name="parent_id" required autofocus />
            </div>
            
        </x-slot>
    
    </x-forms.model-form>

</x-app-layout>

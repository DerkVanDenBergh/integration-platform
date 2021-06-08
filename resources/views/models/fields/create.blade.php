<x-app-layout>
    
    <x-slot name="header">
        {{ __('Model field - create') }}
    </x-slot>

    <x-forms.model-form :action="__('/models/' . $model . '/fields')">

        <x-slot name="method">
            <input name="_method" type="hidden" value="POST">
        </x-slot>

        <x-slot name="fields">

            <div class="col-span-4">
                <x-forms.label for="name" :value="__('Name')" />

                <x-forms.input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>
            
            <div class="col-span-2">
                <x-forms.label for="node_type" :value="__('Node type')" />

                <x-forms.select id="node_type" :value="__('option')" :label="__('label')" :options="$node_types" class="block mt-1 w-full" name="node_type" required autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="data_type" :value="__('Data type')" />

                <x-forms.select id="data_type" :value="__('option')" :label="__('label')" :options="$data_types" class="block mt-1 w-full" name="data_type" autofocus />
            </div>

            @if($fields->count() > 1)
                <div class="col-span-4">
                    <x-forms.label for="parent_id" :value="__('Parent')" />

                    <x-forms.select id="parent_id" :value="__('id')" :label="__('name')" :options="$fields" class="block mt-1 w-full" name="parent_id" autofocus />
                </div>
            @endif
            
        </x-slot>
    
    </x-forms.model-form>

</x-app-layout>

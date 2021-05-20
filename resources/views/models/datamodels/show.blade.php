<x-app-layout>
    
    <x-slot name="header">
        {{ __($model->title . ' - view') }}
    </x-slot>

    <x-subpages.model-view :header="__('Details')" :model="$model" :resource="__('models')">

        <x-slot name="fields">

            <div class="col-span-4">
                <x-forms.label for="title" :value="__('Name')" />

                <x-forms.input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $model->title }}" required disabled autofocus />
            </div>
            
            <div class="col-span-4">
                <x-forms.label for="description" :value="__('Description')" />

                <x-forms.input id="description" class="block mt-1 w-full" type="text" name="description" value="{{ $model->description }}" disabled autofocus />
            </div>

        </x-slot>
    
    </x-subpages.model-view>

    <x-subpages.model-fields :header="__('Model')" :fields="$fields" :showEdit="__(true)" :showDelete="__(true)" :nestedResource="__('/models/' . $model->id)" :resource="__('fields')"></x-subpages.model-fields>

</x-app-layout>

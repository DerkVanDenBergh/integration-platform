<x-app-layout>
    
    <x-slot name="header">
        {{ __($model->title . ' - view') }}
    </x-slot>

    <x-subpages.card :header="__('Details')">
    
        <x-slot name="content">

            <x-details.model-details :model="$model" :resource="__('models')">

                <x-slot name="fields">

                    <x-details.components.attribute :span="__(4)" :type="__('text')" :label="__('Name')" :name="__('title')" :value="$model->title"/>

                    <x-details.components.attribute :span="__(4)" :type="__('text')" :label="__('Description')" :name="__('description')" :value="$model->description"/>

                </x-slot>
            
            </x-details.model-details>

        </x-slot>

    </x-subpages.card>

    <x-subpages.card :header="__('Model')">
    
        <x-slot name="content">

            <x-views.data-model-view  :fields="$fields" :showEdit="__(true)" :showEndpointActions="__(false)" :showDelete="__(true)" :nestedResource="__('/models/' . $model->id)" :resource="__('fields')"/>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

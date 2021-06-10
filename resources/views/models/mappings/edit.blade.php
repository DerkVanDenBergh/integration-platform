<x-app-layout>
    <x-slot name="header">
        {{ __($processable->title . ' - edit mapping') }}
    </x-slot>

    <x-subpages.card :header="__('Mapping')">

        <x-slot name="content">

            <x-forms.model-form :action="__('/processables/' . $processable->id .'/mappings/' . $mapping->id)">

                <x-slot name="method">
                    <input name="_method" type="hidden" value="POST">
                </x-slot>

                <x-slot name="fields">

                    @if($processable->type_id == $processable::ROUTE)

                        <x-forms.components.attribute :span="__(2)" :type="__('select')" :label="__('Input model')" :name="__('input_model')" :optionValue="__('id')" :optionLabel="__('title')" :options="$models" :required="__(true)" :selected="$mapping->input_model"/>
                    
                    @endif

                    @if($processable->type_id == $processable::TASK)

                        <x-forms.components.attribute :span="__(2)" :type="__('select')" :label="__('Input endpoint')" :name="__('input_endpoint')" :optionValue="__('id')" :optionLabel="__('title')" :options="$endpoints" :required="__(true)" :selected="$mapping->input_endpoint"/>
                    
                    @endif

                    <x-forms.components.attribute :span="__(2)" :type="__('select')" :label="__('Output endpoint')" :name="__('output_endpoint')" :optionValue="__('id')" :optionLabel="__('title')" :options="$endpoints" :required="__(true)" :selected="$mapping->output_endpoint"/>

                </x-slot>
            
            </x-forms.model-form>
            
        </x-slot>

    </x-subpages.card>

</x-app-layout>

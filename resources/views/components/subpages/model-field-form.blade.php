<div class="border-2 @if($field->node_type != 'attribute') border-green-300 @else border-indigo-300 @endif overflow-hidden sm:rounded-lg p-2 pl-4 pr-4 mt-4 mb-2">
    <div class="mr-3 inline-block">
        

        @if($field->node_type == 'attribute')
            {{ $field->name }} ->

            <div class="ml-2 col-span-4 inline-block">
                <!-- TODO Make the selected work with a static function or something --> 
                <x-forms.select id="{{ $field->id }}" name="fields[{{ $field->id }}]"  :value="__('id')" :label="__('name')" :selected="$field->getMappedInputField($mapping->id, $field->id)" :options="$availableFields" class="block w-full" required autofocus />
            </div>
        @else
            {{ $field->name }}

            <div class="ml-3 text-gray-400 inline-block">
                {{ $field->node_type }}@if($field->data_type ?? false), {{ $field->data_type }} @endif
            </div>
        @endif
    </div>

    @if (count($field->children()->get()) > 0)
        <div class="gap-4 mt-3">
            @foreach($field->children()->get() as $child)
                <x-subpages.model-field-form :availableFields="$availableFields" :mapping="$mapping" :field="$child" ></x-subpages.model-field-form>
            @endforeach
        </div>
	@endif
</div>
	
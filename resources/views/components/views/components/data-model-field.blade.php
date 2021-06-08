<div class="border-2 @if($field->node_type != 'attribute') border-green-300 @else border-indigo-300 @endif overflow-hidden sm:rounded-lg p-2 pl-4 pr-4 mt-4 mb-2">
    <div class="mr-3 inline-block">
        
        @if($mappingFields ?? false)
            @if( $field->node_type != 'attribute' )
                <div> {{ $field->name }} </div>
            @else
                @if($field->getMappedInputField($mapping->id, $field->id))
                    @if($field->getMappedInputFieldType($mapping->id, $field->id) == 'model')
                        @foreach($mappingFields as $mappingField)
                            @if($mappingField->output_field == $field->id)
                                <div class="inline-block mr-1">{{ $field->name }} -></div><div class="inline-block sm:rounded-lg bg-gray-200 px-1"> {{ $mappingField->model_field_name }} </div>
                            @endif
                        @endforeach
                    @else
                        @foreach($mappingFields as $mappingField)
                            @if($mappingField->output_field == $field->id)
                                <div class="inline-block mr-1">{{ $field->name }} -></div><div class="inline-block sm:rounded-lg bg-gray-200 px-1"> {{ $mappingField->step_field_name }} </div>
                            @endif
                        @endforeach
                    @endif
                @else
                    <div class="inline-block mr-1">{{ $field->name }} -></div><div class="inline-block sm:rounded-lg bg-red-400 text-white px-1"> no output </div>
                @endif
            @endif
        @else
            {{ $field->name }}
        @endif
    </div>

    @if(!($mappingFields ?? true) || ($field->node_type != 'attribute'))
        <div class="text-gray-400 inline-block">
            {{ $field->node_type }}@if($field->data_type ?? false), {{ $field->data_type }} @endif
        </div>
    @endif

    <div class="inline-block text-gray-400 float-right">
        @if($showEdit ?? true)
            <a class="inline-block mr-2 hover:text-green-400 transition" href="/{{ $resource }}/{{ $field->id }}/edit">
                <x-icons.svg-edit class="h-5 w-5"></x-icons.svg-edit>
            </a>
        @endif

        @if($showDelete ?? true)
            <form class="inline-block" method="POST" action="/{{ $resource }}/{{ $field->id }}">
                @csrf

                <input name="_method" type="hidden" value="DELETE">

                <a class="inline-block cursor-pointer hover:text-red-600 transition" onclick="event.preventDefault(); this.closest('form').submit();">
                    <x-icons.svg-delete class="h-5 w-5"></x-icons.svg-delete>
                </a>
            </form>
        @endif
    </div>
    @if (count($field->children()->get()) > 0)
        <div class="gap-4 mt-3">
            @foreach($field->children()->get() as $child)
                <x-views.components.data-model-field :mapping="$mapping" :mappingFields="$mappingFields ?? ''" :field="$child" :showEdit="$showEdit" :showDelete="$showDelete" :resource="$resource ?? ''"></x-views.components.data-model-field>
            @endforeach
        </div>
	@endif
</div>
	
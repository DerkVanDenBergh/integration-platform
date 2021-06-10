@if($fields->count() > 0)
    
    <div class="px-2">

        @foreach ($fields as $field)

            <x-views.components.data-model-field :mapping="$mapping ?? ''" :mappingFields="$mappingFields ?? ''" :field="$field" :showEdit="$showEdit" :showDelete="$showDelete" :resource="$resource ?? ''"/>
        
        @endforeach

    </div>
    
@else

    <x-alerts.empty/>

@endif

<x-buttons.link :active="($showCreate ?? true) ?? (!$showEndpointActions ?? true)" :action="__(($nestedResource ?? false ? ('/' . $nestedResource) : '') . '/' . ($resource ?? '') . '/create')" :caption="__('Add new')" :icon="__('plus')"/>

<x-buttons.link :active="$showEndpointActions ?? false" :action="__('/models/' . ($endpoint ?? false ? $endpoint->model_id : ''))" :caption="__('Edit model')" :icon="__('edit')"/>

<x-buttons.link :active="$showEndpointActions ?? false" :action="__('/endpoints/' . ($endpoint ?? false ? $endpoint->id : '') . '/model')" :caption="__('Swap model')" :icon="__('switch')"/>

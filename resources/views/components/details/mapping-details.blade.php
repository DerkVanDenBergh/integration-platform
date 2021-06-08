@if($mapping->output_endpoint ?? '')

    <div class="grid grid-cols-4 gap-4">

        @if($mapping->type == 'route')

            <x-details.components.attribute :span="__(4)" :type="__('select')" :label="__('Input model')" :name="__('input_model')" :optionValue="__('id')" :optionLabel="__('title')" :options="$models" :selected="$mapping->input_model"/>
        
        @else

            <x-details.components.attribute :span="__(4)" :type="__('select')" :label="__('Input endpoint')" :name="__('input_endpoint')" :optionValue="__('id')" :optionLabel="__('title')" :options="$endpoints" :selected="$mapping->input_endpoint"/>
        
        @endif

        <x-details.components.attribute :span="__(4)" :type="__('select')" :label="__('Output endpoint')" :name="__('output_endpoint')" :optionValue="__('id')" :optionLabel="__('title')" :options="$endpoints" :selected="$mapping->output_endpoint"/>

    </div>
    
    <x-buttons.link :active="__(true)" :action="__('/routes/' . $mapping->processable_id . '/mappings/' . $mapping->id . '/edit')" :caption="__('Edit I/O')" :icon="__('switch')"/>

@else

    <x-alerts.empty :caption="__('No I/O defined yet...')" :message="__('Let\'s get this route started! Select \'add I/O\' to select your input and output models.')"/>

    <x-buttons.link :active="__(true)" :action="__('/routes/' . $mapping->processable_id . '/mappings/' . $mapping->id . '/edit')" :caption="__('Add I/O')" :icon="__('plus')"/>

@endif
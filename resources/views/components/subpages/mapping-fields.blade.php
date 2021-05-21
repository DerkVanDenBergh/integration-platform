<div class="py-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

        @if($header ?? false)
            <h2 class="font-semibold text-l text-green-400 leading-tight pb-3">
                {{ $header }}
            </h2>
        @endif

        <div class="grid grid-cols-11 gap-0 pt-3">

            <div class="col-span-5">
                <div class="text-m px-2 leading-tight">Input model</div>
                <x-subpages.components.model-fields-repeater :fields="$inputFields" :showEdit="__(false)" :showDelete="__(false)" :resource="$resource ?? ''"></x-subpages.components.model-fields-repeater>
            </div>
            <div class="col-span-1 text-center align-middle">
                <x-icons.svg-chevron-right class="h-5 w-5 mr-2 inline align-middle h-full"></x-icons.svg-chevron-right>
            </div>
            <div class="col-span-5">
                <div class="text-m px-2 leading-tight">Result output model</div>
                <x-subpages.components.model-fields-repeater :mapping="$mapping" :mappingFields="$mappingFields" :fields="$outputFields" :showEdit="__(false)" :showDelete="__(false)" :resource="$resource ?? ''"></x-subpages.components.model-fields-repeater>
            </div>

        </div>

            
        <a href="/routes/{{ $mapping->route_id }}/mappings/{{ $mapping->id }}/fields" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
            <x-icons.svg-edit class="h-5 w-5 mr-2"></x-icons.svg-edit>
            <span>Edit mapping</span>
        </a>

    </div>
</div>
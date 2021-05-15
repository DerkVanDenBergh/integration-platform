<div class="py-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

        @if($header ?? false)
            <h2 class="font-semibold text-l text-green-400 leading-tight pb-3">
                {{ $header }}
            </h2>
        @endif

        @if($fields->count() > 0)
            <div class="px-2">
                @foreach ($fields as $field)
                    <x-subpages.model-field :field="$field" :level="__(1)" :showEdit="$showEdit" :showDelete="$showDelete" :resource="$resource ?? ''"></x-subpages.model-field>
                @endforeach
            </div>
            
        @else
            <x-alerts.model-empty></x-alerts.model-empty>
        @endif

        @if($showCreate ?? true)
            <a href="{{ $nestedResource ?? ''}}/{{ $resource }}/create" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                <x-icons.svg-plus class="h-5 w-5 mr-2"></x-icons.svg-plus>
                <span>Add new</span>
            </a>
        @endif

        @if($showEndpointActions ?? false)
            
            @if($endpoint->model_id ?? false)
                <a href="/models/{{ $endpoint->model_id }}" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                    <x-icons.svg-edit class="h-5 w-5 mr-2"></x-icons.svg-edit>
                    <span>Edit model</span>
                </a>

                <a href="/endpoints/{{ $endpoint->id }}/model" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                    <x-icons.svg-switch class="h-5 w-5 mr-2"></x-icons.svg-switch>
                    <span>Swap model</span>
                </a>
            @else
                <a href="/endpoints/{{ $endpoint->id }}/model" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                    <x-icons.svg-plus class="h-5 w-5 mr-2"></x-icons.svg-plus>
                    <span>Add model</span>
                </a>
            @endif
        @endif

    </div>
</div>
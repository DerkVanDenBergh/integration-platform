<div class="py-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

        @if($header ?? false)
            <h2 class="font-semibold text-l text-green-400 leading-tight pb-3">
                {{ $header }}
            </h2>
        @endif

        @if($steps->count() > 0)
            <div class="px-2">
                @foreach ($route->getMapping()->getFields()->count() as $field)
                    <x-subpages.model-mapping-field :field="$field" :showEdit="$showEdit" :showDelete="$showDelete" :resource="$resource ?? ''"></x-subpages.model-mapping-field>
                @endforeach
            </div>

            <a href="/route/{{ $route->id }}/steps" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                <x-icons.svg-edit class="h-5 w-5 mr-2"></x-icons.svg-edit>
                <span>Edit steps</span>
            </a>
        @else
            <x-alerts.model-empty>
                
                <x-slot name="customAlert">
                    <div>
                        <p class="font-bold">No steps defined yet...</p>
                        <p class="text-sm">Don't worry, some routes don't need a lot of steps to reach the destination!</p>
                    </div>
                </x-slot>

            </x-alerts.model-empty>

            <a href="/route/{{ $route->id }}/steps" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                <x-icons.svg-plus class="h-5 w-5 mr-2"></x-icons.svg-plus>
                <span>Add steps</span>
            </a>
        @endif

    </div>
</div>
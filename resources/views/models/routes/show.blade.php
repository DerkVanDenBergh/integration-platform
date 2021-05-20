<x-app-layout>
    
    <x-slot name="header">
        {{ __($route->title . ' - view') }}
    </x-slot>

    <x-subpages.model-view :header="__('Details')" :model="$route" :resource="__('routes')">

        <x-slot name="fields">

            <div class="col-span-2">
                <x-forms.label for="title" :value="__('Name')" />

                <x-forms.input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $route->title }}" required disabled autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="url" :value="__('URL')" />

                <x-forms.input id="url" class="block mt-1 w-full" type="text" name="url" value="{{ url('/hooks/') . '/' . $route->slug }}" required disabled autofocus />
            </div>

            <div class="col-span-4">
                <x-forms.label for="description" :value="__('Description')" />

                <x-forms.input id="description" class="block mt-1 w-full" type="text" name="description" value="{{ $route->description }}" required disabled autofocus />
            </div>

            <div class="col-span-4">
                <label for="active" class="inline-flex items-center">
                    <input id="active" type="checkbox" @if($route->active) checked @endif disabled class="rounded border-gray-300 text-green-400 shadow-sm focus:border-green-400 focus:ring focus:ring-green-200 focus:ring-opacity-50" name="can_manage_templates">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Active') }}</span>
                </label>
            </div>

        </x-slot>
    
    </x-subpages.model-view>

    <x-subpages.mapping-io :header="__('Input/output')" :mapping="$mapping" :models="$models" :endpoints="$endpoints"></x-subpages.mapping-io>

    <x-subpages.route-steps :header="__('Steps')" :route="$route" :steps="$steps" :inputModelFields="$inputModelFields"></x-subpages.route-steps>

    @if($outputModel ?? false)
        <x-subpages.mapping-fields 
            :header="__('Mapping')" 
            :mapping="$mapping" :mappingFields="$mappingFields" 
            :input="$inputModel" :inputFields="$inputModelFields"  
            :output="$outputModel" :outputFields="$outputModelFields">
        </x-subpages.mapping-fields>
    @endif

    <x-subpages.model-table :header="__('Runs')" :fields="array('id', 'status', 'created_at')" :list="$runs" :resource="__('runs')" :showEdit="__(false)" :showDelete="__(false)" showCreate="__(false)">
        <x-slot name="headers">
            <th class="w-1/4 py-2">ID</th>
            <th class="w-1/4 py-2">Status</th>
            <th class="w-1/4 py-2">Processed at</th>
            <th class="w-1/4 py-2">Actions</th>
        </x-slot>
    </x-subpages.model-table>
</x-app-layout>

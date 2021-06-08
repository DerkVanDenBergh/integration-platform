<x-app-layout>
    
    <x-slot name="header">
        {{ __($route->title . ' - view') }}
    </x-slot>

    <x-subpages.card :header="__('Details')">

        <x-slot name="content">

            <x-details.model-details  :model="$route" :resource="__('routes')">

                <x-slot name="fields">

                    <x-details.components.attribute :span="__(2)" :type="__('text')" :label="__('Name')" :name="__('title')" :value="$route->title"/>

                    <x-details.components.attribute :span="__(2)" :type="__('text')" :label="__('URL')" :name="__('url')" :value="__(url('/hooks/') . '/' . $route->slug)"/>

                    <x-details.components.attribute :span="__(4)" :type="__('text')" :label="__('Description')" :name="__('description')" :value="$route->description"/>

                    <x-details.components.attribute :span="__(4)" :type="__('checkbox')" :label="__('Active')" :name="__('description')" :checked="$route->active"/>

                </x-slot>
            
            </x-details.model-details>

        </x-slot>

    </x-subpages.card>


    <x-subpages.card :header="__('Input/output')">

        <x-slot name="content">

            <x-details.mapping-details :mapping="$mapping" :models="$models" :endpoints="$endpoints"/>
        
        </x-slot>
    
    </x-subpages.card>


    <x-subpages.card :header="__('Steps')">
    
        <x-slot name="content">

            <x-alerts.info :caption="__('Did you know?')" :message="__('You can use the values of fields and earlier steps in your steps! To do so, you need to write them in a special manner.')" class="mb-3">
        
                <x-slot name="content">

                    @if($inputModelFields ?? false)
                        A couple of examples for your route:
                        <div class="inline-block sm:rounded-lg bg-gray-200 px-1.5 pb-0.5 mr-1 mt-1"> 
                            ![{{ $inputModelFields[0]->name }}]
                        </div>
                        @if($inputModelFields->count() > 1)
                            <div class="inline-block sm:rounded-lg bg-gray-200 px-1.5 pb-0.5 mr-1 mt-1"> 
                                ![{{ $inputModelFields[1]->name }}]
                            </div>
                        @endif
                    @else
                        A couple of examples:
                        <div class="inline-block sm:rounded-lg bg-gray-200 px-1.5 pb-0.5 mr-1 mt-1"> 
                            ![id]
                        </div>
                        <div class="inline-block sm:rounded-lg bg-gray-200 px-1.5 pb-0.5 mr-1 mt-1"> 
                            ![name]
                        </div>
                    @endif

                </x-slot>

            </x-alerts.info>

            <x-tables.model-table :fields="array('order', 'name')" :list="$steps" :resource="__('steps')" :showEdit="__(false)" :showDelete="__(false)" :showCreate="__(false)" :showView="__(false)">

                <x-slot name="headers">
                    <th class="w-1/10 py-2">Order</th>
                    <th class="w-4/5 py-2">Name</th>
                    <th class="w-1/10 py-2"></th>
                </x-slot>
            
            </x-tables.model-table>

            <a href="/processables/{{ $route->id }}/steps" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                <x-icons.svg-edit class="h-5 w-5 mr-2"></x-icons.svg-edit>
                <span>Edit steps</span>
            </a>

        </x-slot>

    </x-subpages.card>

    @if($outputModel ?? false)

        <x-subpages.card :header="__('Mapping')" >

            <x-slot name="content">

                <x-views.data-mapping-view 
                    :mapping="$mapping" :mappingFields="$mappingFields" 
                    :input="$inputModel" :inputFields="$inputModelFields"  
                    :output="$outputModel" :outputFields="$outputModelFields">
                </x-views.data-mapping-view>

                <a href="/processables/{{ $mapping->processable_id }}/mappings/{{ $mapping->id }}/fields" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                    <x-icons.svg-edit class="h-5 w-5 mr-2"></x-icons.svg-edit>
                    <span>Edit mapping</span>
                </a>

            </x-slot>

        </x-subpages.card>

    @endif


    <x-subpages.card :header="__('Runs')">
    
        <x-slot name="content">

            <x-tables.model-table :fields="array('id', 'status', 'created_at')" :list="$runs" :resource="__('runs')" :showEdit="__(false)" :showDelete="__(false)" showCreate="__(false)">
                
                <x-slot name="headers">
                    <th class="w-1/4 py-2">ID</th>
                    <th class="w-1/4 py-2">Status</th>
                    <th class="w-1/4 py-2">Processed at</th>
                    <th class="w-1/4 py-2">Actions</th>
                </x-slot>

            </x-tables.model-table>

        </x-slot>

    </x-subpages.card>

</x-app-layout>

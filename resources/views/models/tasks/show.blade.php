<x-app-layout>
    
    <x-slot name="header">
        {{ __($task->title . ' - view') }}
    </x-slot>

    <x-subpages.card :header="__('Details')">

        <x-slot name="content">

            <x-details.model-details  :model="$task" :resource="__('tasks')">

                <x-slot name="fields">

                    <x-details.components.attribute :span="__(2)" :type="__('text')" :label="__('Name')" :name="__('title')" :value="$task->title"/>

                    <x-details.components.attribute :span="__(2)" :type="__('number')" :label="__('Execution interval (min)')" :name="__('interval')" :value="$task->interval"/>

                    <x-details.components.attribute :span="__(4)" :type="__('text')" :label="__('Description')" :name="__('description')" :value="$task->description"/>

                    <x-details.components.attribute :span="__(4)" :type="__('checkbox')" :label="__('Active')" :name="__('description')" :checked="$task->active"/>

                </x-slot>
            
            </x-details.model-details>

            <x-buttons.link :active="__(true)" :action="__('/tasks/' . $task->id . '/execute')" :caption="__('Execute')" :icon="__('play')"/>

        </x-slot>

    </x-subpages.card>


    <x-subpages.card :header="__('Input/output')">

        <x-slot name="content">

            <x-details.model-details :model="$mapping" :resource="__('mappings')" :showEdit="__(false)">
            
                <x-slot name="fields">
                    
                    @if($mapping->output_endpoint ?? false)

                        <x-details.components.attribute :span="__(4)" :type="__('select')" :label="__('Input endpoint')" :name="__('input_endpoint')" :optionValue="__('id')" :optionLabel="__('title')" :options="$models" :selected="$mapping->input_endpoint"/>

                        <x-details.components.attribute :span="__(4)" :type="__('select')" :label="__('Output endpoint')" :name="__('output_endpoint')" :optionValue="__('id')" :optionLabel="__('title')" :options="$endpoints" :selected="$mapping->output_endpoint"/>

                    @else

                        <x-alerts.empty :caption="__('No I/O defined yet...')" :message="__('Let\'s get this task started! Select \'add I/O\' to select your input and output models.')" class="col-span-4"/>

                    @endif
                
                </x-slot>

            </x-details.model-details>

            <x-buttons.link :active="__(true)" :action="__('/processables/' . $mapping->processable_id . '/mappings/' . $mapping->id . '/edit')" :caption="__('Edit I/O')" :icon="__('switch')"/>
        
        </x-slot>
    
    </x-subpages.card>


    <x-subpages.card :header="__('Steps')">
    
        <x-slot name="content">

            @if($steps->count() > 0)

                <x-alerts.info :caption="__('Did you know?')" :message="__('You can use the values of fields and earlier steps in your steps! To do so, you need to write them in a special manner.')" class="mb-3">
            
                    <x-slot name="content">

                        @if($inputModelFields ?? false)
                            A couple of examples for your task:
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

            @endif

            <x-tables.model-table :fields="array('order', 'name')" :list="$steps" :resource="__('steps')" :showEdit="__(false)" :showDelete="__(false)" :showCreate="__(false)" :showView="__(false)">

                <x-slot name="headers">
                    <th class="w-1/10 py-2">Order</th>
                    <th class="w-4/5 py-2">Name</th>
                    <th class="w-1/10 py-2"></th>
                </x-slot>
            
            </x-tables.model-table>

            <a href="/processables/{{ $task->id }}/steps" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                <x-icons.svg-edit class="h-5 w-5 mr-2"></x-icons.svg-edit>
                <span>Edit steps</span>
            </a>

        </x-slot>

    </x-subpages.card>

    @if($outputModel ?? false)

        <x-subpages.card :header="__('Mapping')" >

            <x-slot name="content">

                @if(isset($inputModelFields) and isset($outputModelFields))

                    <x-views.data-mapping-view 
                        :mapping="$mapping" :mappingFields="$mappingFields" 
                        :input="$inputModel" :inputFields="$inputModelFields"  
                        :output="$outputModel" :outputFields="$outputModelFields">
                    </x-views.data-mapping-view>

                     <a href="/processables/{{ $mapping->processable_id }}/mappings/{{ $mapping->id }}/fields" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                        <x-icons.svg-edit class="h-5 w-5 mr-2"></x-icons.svg-edit>
                        <span>Edit mapping</span>
                    </a>

                @else

                    <x-alerts.warning :caption="__('You forgot something!')" :message="__('One of your endpoints does not have a valid model yet!')" class="mb-3"/>

                @endif

            </x-slot>

        </x-subpages.card>

    @endif


    <x-subpages.card :header="__('Executions')">
    
        <x-slot name="content">

            <x-tables.model-table :fields="array('id', 'status', 'created_at')" :list="$runs" :resource="__('runs')" :showEdit="__(false)" :showDelete="__(false)" :showCreate="__(false)">
                
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

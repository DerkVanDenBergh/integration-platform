<div class="py-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

        @if($header ?? false)
            <h2 class="font-semibold text-l text-green-400 leading-tight pb-3">
                {{ $header }}
            </h2>
        @endif

        @if($mapping->output_endpoint ?? '')
            <div class="grid grid-cols-4 gap-4">

                @if($mapping->type == 'route')
                    <div class="col-span-4">
                        <x-forms.label for="input_model" :value="__('Input model')" />

                        <x-forms.select id="input_model" :value="__('id')" :label="__('title')" :selected="$mapping->input_model" :options="$models" class="block mt-1 w-full" name="input_model" required disabled autofocus />
                    </div>
                @else
                    <div class="col-span-4">
                        <x-forms.label for="input_endpoint" :value="__('Input endpoint')" />

                        <x-forms.select id="input_endpoint" :value="__('id')" :label="__('title')" :selected="$mapping->input_endpoint" :options="$endpoints" class="block mt-1 w-full" name="input_endpoint" required disabled autofocus />
                    </div>
                @endif

                <div class="col-span-4">
                    <x-forms.label for="output_endpoint" :value="__('Output endpoint')" />

                    <x-forms.select id="output_endpoint" :value="__('id')" :label="__('title')" :selected="$mapping->output_endpoint" :options="$endpoints" class="block mt-1 w-full" name="output_endpoint" required disabled autofocus />
                </div>

            </div>
            
            <a href="/routes/{{ $mapping->route_id }}/mappings/{{ $mapping->id }}/edit" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                <x-icons.svg-switch class="h-5 w-5 mr-2"></x-icons.svg-switch>
                <span>Edit I/O</span>
            </a>
        @else
            <x-alerts.model-empty>
                <x-slot name="customAlert">
                    <div>
                        <p class="font-bold">No I/O defined yet...</p>
                        <p class="text-sm">Let's get this route started! Select 'add I/O' to select your input and output models.</p>
                    </div>
                </x-slot>
            </x-alerts.model-empty>

            <a href="/routes/{{ $mapping->route_id }}/mappings/{{ $mapping->id }}/edit" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                <x-icons.svg-plus class="h-5 w-5 mr-2"></x-icons.svg-plus>
                <span>Add I/O</span>
            </a>
        @endif
    </div>
</div>
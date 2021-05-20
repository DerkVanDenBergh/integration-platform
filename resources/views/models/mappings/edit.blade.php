<x-app-layout>
    <x-slot name="header">
        {{ __($route->title . ' - edit') }}
    </x-slot>

    <x-subpages.model-form :action="__('/routes/' . $route->id . '/mappings/' . $mapping->id)">

        <x-slot name="method">
            <input name="_method" type="hidden" value="PUT">
        </x-slot>

        <x-slot name="fields">

            @if($mapping->type == 'route')
                <div class="col-span-2">
                    <x-forms.label for="input_model" :value="__('Input model')" />

                    <x-forms.select id="input_model" :value="__('id')" :label="__('title')" :options="$models" :selected="$mapping->input_model" class="block mt-1 w-full" name="input_model" required autofocus />
                </div>
            @else
                <div class="col-span-2">
                    <x-forms.label for="input_endpoint" :value="__('Input Endpoint')" />

                    <x-forms.select id="input_endpoint" :value="__('id')" :label="__('title')" :options="$endpoints" :selected="$mapping->input_endpoint" class="block mt-1 w-full" name="input_endpoint" required autofocus />
                </div>
            @endif

            <div class="col-span-2">
                <x-forms.label for="output_endpoint" :value="__('Input Endpoint')" />

                <x-forms.select id="output_endpoint" :value="__('id')" :label="__('title')" :options="$endpoints" :selected="$mapping->output_endpoint" class="block mt-1 w-full" name="output_endpoint" required autofocus />
            </div>

        </x-slot>
    
    </x-subpages.model-form>

</x-app-layout>

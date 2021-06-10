<div class="bg-blue-300 bg-white overflow-hidden sm:rounded-lg p-2 pl-4 pr-4 mt-4 mb-2 step-container" id="{{ $number }}">
    
    <x-forms.components.primitives.input id="steps[{{ $number }}][name]" class="inline-block mt-1 h-8" type="text" name="steps[{{ $number }}][name]" value="{{ $step->name ?? '' }}" placeholder="Step name" required autofocus />
        
    <div class="block text-gray-400 sm:rounded-lg bg-white px-2 float-right mt-1 pt-1">
        
        @if($showDelete ?? true)

            <a href="#" class="inline-block cursor-pointer hover:text-red-600 transition delete-button">
                <x-icons.svg-delete class="h-5 w-5"></x-icons.svg-delete>
            </a>
            
        @endif

    </div>

    <div class="bg-white overflow-hidden sm:rounded-lg p-2 pl-4 pr-4 mt-4 mb-2">
        <div class="w-full inline-block capitalize">

            {{-- TODO refactor these inputs to attribute inputs --}}

            <x-forms.components.primitives.label for="steps[{{ $number }}][step_function_id]" :value="__('Function')" />

            <x-forms.components.primitives.select id="steps[{{ $number }}][step_function_id]" :value="__('id')" :label="__('name')" :selected="($function->id ?? '')" :options="$functions" class="block mt-1 w-full" name="steps[{{ $number }}][step_function_id]" required autofocus />

        </div>


        <div class="text-sm pt-2 description-container">

            @if($function ?? false)

                {{ $function->description }}

            @endif
        </div>

        <div class="grid grid-cols-4 gap-4 argument-container">
            
            @if($parameters ?? false)
                @foreach($parameters as $parameter)

                    <div class="col-span-2 py-4">
                        <x-forms.components.primitives.label for="steps[{{ $number }}][arguments][{{ $parameter->id }}]" :value="__('Parameter ' . $loop->index + 1 . ': '. $parameter->name)" />
                        @if($parameter->is_nullable)
                            <x-forms.components.primitives.input id="steps[{{ $number }}][arguments][{{ $parameter->id }}]" class="block mt-1 w-full" type="text" name="steps[{{ $number }}][arguments][{{ $parameter->id }}]" value="{{ $parameter->getArgumentValueByStepId($step->id) }}" autofocus />
                        @else
                            <x-forms.components.primitives.input id="steps[{{ $number }}][arguments][{{ $parameter->id }}]" class="block mt-1 w-full" type="text" name="steps[{{ $number }}][arguments][{{ $parameter->id }}]" value="{{ $parameter->getArgumentValueByStepId($step->id) }}" required autofocus />
                        @endif
                    </div>
                    
                @endforeach
            @endif
            
         </div>
    </div>
</div>

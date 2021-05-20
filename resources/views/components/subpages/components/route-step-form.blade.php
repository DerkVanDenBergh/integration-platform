<div class="bg-blue-300 bg-white overflow-hidden sm:rounded-lg p-2 pl-4 pr-4 mt-4 mb-2 step-container" id="{{ $number }}">
    
    <x-forms.input id="steps[{{ $number }}][name]" class="inline-block mt-1 h-8" type="text" name="steps[{{ $number }}][name]" value="{{ $step->name ?? '' }}" required autofocus />
        
    <div class="block text-gray-400 sm:rounded-lg bg-white px-2 float-right mt-1 pt-1">
        @if($showDelete ?? true)
            <a href="#" class="inline-block cursor-pointer hover:text-red-600 transition delete-button">
                <x-icons.svg-delete class="h-5 w-5"></x-icons.svg-delete>
            </a>
        @endif
    </div>

    <div class="bg-white overflow-hidden sm:rounded-lg p-2 pl-4 pr-4 mt-4 mb-2">
        <div class="w-full inline-block capitalize">

            <x-forms.label for="steps[{{ $number }}][step_function_id]" :value="__('Function')" />

            <x-forms.select id="steps[{{ $number }}][step_function_id]" :value="__('id')" :label="__('name')" :selected="($function->id ?? '')" :options="$functions" class="block mt-1 w-full" name="steps[{{ $number }}][step_function_id]" required autofocus />

        </div>

        <div class="text-sm pt-2">
            {{ $function->description }}
        </div>

        <div class="grid grid-cols-4 gap-4 argument-container">
            @if($arguments ?? false)
                @foreach($arguments as $argument)

                    <div class="col-span-2 py-4">
                        <x-forms.label for="steps[{{ $number }}][arguments][{{ $argument->step_function_parameter()->first()->id }}]" :value="__('Parameter ' . $loop->index + 1 . ': '. $argument->step_function_parameter()->first()->name)" />
                        @if($argument->step_function_parameter()->first()->is_nullable)
                            <x-forms.input id="steps[{{ $number }}][arguments][{{ $argument->step_function_parameter()->first()->id }}]" class="block mt-1 w-full" type="text" name="steps[{{ $number }}][arguments][{{ $argument->step_function_parameter()->first()->id }}]" value="{{ $argument->value }}" autofocus />
                        @else
                            <x-forms.input id="steps[{{ $number }}][arguments][{{ $argument->step_function_parameter()->first()->id }}]" class="block mt-1 w-full" type="text" name="steps[{{ $number }}][arguments][{{ $argument->step_function_parameter()->first()->id }}]" value="{{ $argument->value }}" required autofocus />
                        @endif
                    </div>
                    
                @endforeach
            @endif
            
         </div>

    </div>

</div>

<div class="col-span-{{ $span }}">
    
    @switch($type) {{-- TODO make these not form components --}}

        @case('select')

            @if($label ?? false)
                <x-forms.components.primitives.label for="{{ $name }}" :value="$label" />
            @endif

            <x-forms.components.primitives.select id="{{ $name }}" :value="$optionValue" :label="$optionLabel" :selected="$selected" :options="$options" class="block mt-1 w-full" name="{{ $name }}" autofocus disabled />

            @break

        @case('textarea')

            @if($label ?? false)
                <x-forms.components.primitives.label for="{{ $name }}" :value="$label" />
            @endif

            <x-forms.components.primitives.textarea id="{{ $name }}" class="block mt-1 w-full" height="$height" name="{{ $name }}" value="$value" autofocus disabled/>
            
            @break

        @case('checkbox')

            @if($label ?? false)
                <x-forms.components.primitives.label for="{{ $name }}" :value="$label" />
            @endif

            <x-forms.components.primitives.checkbox id="{{ $name }}" :checked="$checked" name="{{ $name }}" autofocus disabled />
            
            @break
        
        @default

            @if($label ?? false)
                <x-forms.components.primitives.label for="{{ $name }}" :value="$label" />
            @endif

            <x-forms.components.primitives.input id="{{ $name }}" class="block mt-1 w-full" type="{{ $type }}" name="{{ $name }}" :value="$value" autofocus disabled/>

    @endswitch

</div>
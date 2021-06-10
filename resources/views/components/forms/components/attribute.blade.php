<div class="col-span-{{ $span }}">
    
    @switch($type)

        @case('select')

            @if($label ?? false)
                <x-forms.components.primitives.label for="{{ $name }}" :value="$label" />
            @endif

            <x-forms.components.primitives.select id="{{ $name }}" :value="$optionValue" :label="$optionLabel" :selected="__($selected ?? '')" :options="$options" class="block mt-1 w-full" name="{{ $name }}" :required="__($required ?? false)" autofocus />

            @break

        @case('textarea')

            @if($label ?? false)
                <x-forms.components.primitives.label for="{{ $name }}" :value="$label" />
            @endif

            <x-forms.components.primitives.textarea id="{{ $name }}" class="block mt-1 w-full" height="$height" name="{{ $name }}" value="$value" :required="__($required ?? false)" autofocus />
            
            @break

        @case('checkbox')

            @if($label ?? false)
                <x-forms.components.primitives.label for="{{ $name }}" :value="$label" />
            @endif

            <x-forms.components.primitives.checkbox id="{{ $name }}" :checked="__($checked ?? false)" name="{{ $name }}" :required="__($required ?? false)" autofocus />
            
            @break
        
        @default

            @if($label ?? false)
                <x-forms.components.primitives.label for="{{ $name }}" :value="$label" />
            @endif

            <x-forms.components.primitives.input id="{{ $name }}" class="block mt-1 w-full" type="{{ $type }}" name="{{ $name }}" :value="$value" :required="__($required ?? false)" autofocus />

    @endswitch

</div>
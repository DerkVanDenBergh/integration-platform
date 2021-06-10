<select {{ ($required ?? false) ? 'required' : '' }}  {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-green-400 focus:ring focus:ring-green-200 focus:ring-opacity-50 disabled:bg-gray-600']) !!}>
    @foreach($options as $option)
        {{-- Really ugly, make this dynamic in the form of an array or something  --}}
        @if($secondValue ?? false)
            @if($selected ?? false)
                <option @if($selected == ($option->$value . '-' . $option->$secondValue)) selected @endif value="{{$option->$value}}@if($secondValue ?? false)-{{$option->$secondValue}} @endif">{{$option->$label}}</option>
            @else 
                <option value="{{$option->$value}}@if($secondValue ?? false)-{{$option->$secondValue}}@endif">{{$option->$label}}</option>
            @endif
        @else
            @if($selected ?? false)
                <option @if($selected == $option->$value) selected @endif value="{{$option->$value}}">{{$option->$label}}</option>
            @else {{-- Really ugly, make this dynamic in the form of an array or something  --}}
                <option value="{{$option->$value}}">{{$option->$label}}</option>
            @endif
        @endif
    @endforeach
</select>
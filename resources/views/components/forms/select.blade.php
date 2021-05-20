<select {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-green-400 focus:ring focus:ring-green-200 focus:ring-opacity-50 disabled:bg-gray-600']) !!}>
    @foreach($options as $option)
        @if($selected ?? false)
            <option @if($selected == $option->$value) selected @endif value="{{$option->$value}}">{{$option->$label}}</option>
        @else
            <option value="{{$option->$value}}">{{$option->$label}}</option>
        @endif
    @endforeach
</select>
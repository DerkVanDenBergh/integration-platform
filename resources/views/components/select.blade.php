<select {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
    @foreach($options as $option)
        @if(isset($selected))
            <option @if($selected == $option->$value) selected @endif value="{{$option->$value}}">{{$option->$label}}</option>
        @else
            <option value="{{$option->$value}}">{{$option->$label}}</option>
        @endif
    @endforeach
</select>
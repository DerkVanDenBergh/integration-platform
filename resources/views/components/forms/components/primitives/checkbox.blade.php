<input type="checkbox" {{ ($required ?? false) ? 'required' : '' }} {{ $checked ? 'checked' : ''}} {!! $attributes->merge(['class' => 'rounded border-gray-300 text-green-400 shadow-sm focus:border-green-400 focus:ring focus:ring-green-200 focus:ring-opacity-50']) !!}>

@if($active ?? true) 
    <a href="{{ $action }}" {{ $attributes->merge(['class' => 'mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center']) }}>
        <x-icons.factory :icon="$icon"/>
        
        <span>{{ $caption }}</span>
    </a>
@endif
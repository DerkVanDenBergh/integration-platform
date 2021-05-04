<div class="py-4">

    <div {!! $attributes->merge(['class' => 'bg-white overflow-hidden shadow-sm sm:rounded-lg p-5']) !!}>
        
        @if(isset($header))
            <h2 class="font-semibold text-l text-indigo-600 leading-tight pb-3">
                {{ $header }}
            </h2>
        @endif
        
        {{ $content }}
    </div>
</div>
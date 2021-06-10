<div {!! $attributes->merge(['class' => 'inline-block border-t-4 border-red-400 rounded-b text-gray-700 px-4 py-3 shadow-md w-full', 'role' => 'alert']) !!}>
    <div class="inline-block">
        <div class="inline-block py-1">            
            <svg class=" h-6 w-7 text-teal-500 mr-4" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        
        <div class="inline-block font-bold py-1 align-top">

            @if($caption ?? false)
                {{ $caption }}
            @else
                Danger!
            @endif

        </div>

        <p class="inline-block text-sm w-full">

            @if($message ?? false)
                {{ $message }}
            @else
                Something went very wrong.
            @endif
            
        </p>

        @if($content ?? false)

            <p class="inline-block text-sm w-full">
                
                {{ $content }}
            
            </p>
        
        @endif
    </div>
</div>
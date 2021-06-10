<div {!! $attributes->merge(['class' => 'inline-block border-t-4 border-yellow-400 rounded-b text-gray-700 px-4 py-3 shadow-md w-full', 'role' => 'alert']) !!}>
    <div class="inline-block">
        <div class="inline-block py-1">
            <svg class=" h-6 w-7 text-teal-500 mr-4" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        
        <div class="inline-block font-bold py-1 align-top">

            @if($caption ?? false)
                {{ $caption }}
            @else
                Warning!
            @endif

        </div>

        <p class="inline-block text-sm w-full">

            @if($message ?? false)
                {{ $message }}
            @else
                Something is about to go wrong if you don't take action.
            @endif
            
        </p>

        @if($content ?? false)

            <p class="inline-block text-sm w-full">
                
                {{ $content }}
            
            </p>
        
        @endif
    </div>
</div>
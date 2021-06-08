

@if($active ?? true) 
    @if($method ?? false)

        <form class="inline-block" method="POST" action="{{ $action }}">
            @csrf

            <input name="_method" type="hidden" value="{{ $method }}">

            <a class="inline-block cursor-pointer {{ $danger ?? false ? 'hover:text-red-400' : 'hover:text-green-400'}} transition" onclick="event.preventDefault(); this.closest('form').submit();">
                <x-icons.factory :icon="$icon"/>
            </a>
        </form>

    @else
        
        <a class="inline-block {{ $danger ?? false ? 'hover:text-red-400' : 'hover:text-green-400'}} transition" href="{{ $action }}">
            <x-icons.factory :icon="$icon"/>
        </a>

    @endif

@endif
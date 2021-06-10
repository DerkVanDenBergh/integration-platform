@switch($icon) 

    @case('check')
        <x-icons.svg-check class="h-5 w-5 mr-2"/>
        @break

    @case('chevron-right')
        <x-icons.svg-chevron-right class="h-5 w-5 mr-2"/>
        @break

    @case('delete')
        <x-icons.svg-delete class="h-5 w-5 mr-2"/>
        @break

    @case('edit')
        <x-icons.svg-edit class="h-5 w-5 mr-2"/>
        @break

    @case('plus')
        <x-icons.svg-plus class="h-5 w-5 mr-2"/>
        @break

    @case('switch')
        <x-icons.svg-switch class="h-5 w-5 mr-2"/>
        @break

    @case('view')
        <x-icons.svg-view class="h-5 w-5 mr-2"/>
        @break

    @case('play')
        <x-icons.svg-play class="h-5 w-5 mr-2"/>
        @break
    
    @default

        <x-icons.svg-edit class="h-5 w-5 mr-2"/>

@endswitch
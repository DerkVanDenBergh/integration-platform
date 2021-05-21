@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
@endpush

<x-app-layout>
    
    <x-slot name="header">
        {{ __($route->title . ' - view') }}
    </x-slot>

    <x-subpages.route-steps :form="__(true)" :action="__('/routes/' . $route->id . '/steps')" :steps="$steps" :route="$route" :functions="$functions"></x-subpages.route-steps>
</x-app-layout>

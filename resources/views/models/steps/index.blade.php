@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
@endpush

<x-app-layout>
    
    <x-slot name="header">
        {{ __($processable->title . ' - view') }}
    </x-slot>

    <x-subpages.card>
    
        <x-slot name="content">
            
            <x-forms.steps-form :action="__('/processables/' . $processable->id . '/steps')" :steps="$steps" :processable="$processable" :functions="$functions"/>

         </x-slot>

    </x-subpages.card>
    
</x-app-layout>

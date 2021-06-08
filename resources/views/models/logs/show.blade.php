<x-app-layout>
    
    <x-slot name="header">
        {{ __('Log entry #' . $log->id) }}
    </x-slot>

    <x-subpages.card :header="__('Details')">

        <x-slot name="content">

            <div class="w-full mb-5">
                <x-forms.components.primitives.label for="input_model" :value="__('Title')" />

                {{ $log->title }}
            <div>
            
            
            <div class="w-full my-5 break-words">
                <x-forms.components.primitives.label for="input_model" :value="__('Description')" />

                @if($log->message)
                    {{ $log->message }}
                @else
                    No further information.
                @endif
            <div>
            

            @if($log->stacktrace)
                <div class="w-full my-5">
                    <x-forms.components.primitives.label for="input_model" :value="__('Stacktrace')" />

                    {{ $log->stacktrace }}
                <div>
            @endif
            
        </x-slot>

    </x-subpages.card>

</x-app-layout>

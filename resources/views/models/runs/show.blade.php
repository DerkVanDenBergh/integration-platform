<x-app-layout>
    
    <x-slot name="header">
        {{ __('Run #' . $run->id) }}
    </x-slot>

    <x-subpages.card :header="__('Details')">

        <x-slot name="content">

            <div class="w-full mb-5">
                <x-forms.components.primitives.label :value="__('Status')" />

                {{ $run->status }}
            <div>
            
            
            <div class="w-full my-5 break-words">
                <x-forms.components.primitives.label :value="__('Input')" />

                @if($run->input && ($run->input != ''))
                    {{ $run->input }}
                @else
                    No input registered.
                @endif
            <div>
            

            <div class="w-full my-5 break-words">
                <x-forms.components.primitives.label :value="__('Output')" />

                @if($run->output && ($run->output != ''))
                    {{ $run->output }}
                @else
                    No output registered.
                @endif
            <div>
            
        </x-slot>

    </x-subpages.card>

</x-app-layout>

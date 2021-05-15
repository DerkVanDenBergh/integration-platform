<x-app-layout>
    
    <x-slot name="header">
        {{ __('Model - create') }}
    </x-slot>

    <x-subpages.model-form :action="__('/models/create/definition')">

        <x-slot name="method">
            <input name="_method" type="hidden" value="POST">
        </x-slot>

        <x-slot name="fields">

            <div class="col-span-4">
                <x-forms.label for="title" :value="__('Name')" />

                <x-forms.input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
            </div>
            
            <div class="col-span-4">
                <x-forms.label for="description" :value="__('Description')" />

                <x-forms.input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" autofocus />
            </div>

            <div class="col-span-4">
                <x-forms.label for="definition" :value="__('Definition')" />

                <x-textarea id="definition" class="block mt-1 w-full" height="10" name="definition" value="old('definition')" autofocus />
            </div>
            
        </x-slot>
    
    </x-subpages.model-form>

</x-app-layout>

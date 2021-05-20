<x-app-layout>
    <x-slot name="header">
        {{ __('Authentication - create') }}
    </x-slot>

    <x-subpages.model-form :action="__('/connections/' . $connection . '/authentications')">

        <x-slot name="method">
            <input name="_method" type="hidden" value="POST">
        </x-slot>

        <x-slot name="fields">

            <div class="col-span-4">
                <x-forms.input id="type" type="hidden" name="type" value="{{ $type }}" required autofocus />
            </div>

            <div class="col-span-4">
                <x-forms.label for="title" :value="__('Name')" />

                <x-forms.input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
            </div>
            
            <div class="col-span-4">
                <x-forms.label for="key" :value="__('API key')" />

                <x-forms.input id="key" class="block mt-1 w-full" type="text" name="key" :value="old('key')" required autofocus />
            </div>
            
        </x-slot>
    
    </x-subpages.model-form>

</x-app-layout>

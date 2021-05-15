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
                <x-forms.label for="token" :value="__('API token')" />

                <x-forms.input id="token" class="block mt-1 w-full" type="text" name="token" :value="old('token')" required autofocus />
            </div>
            
        </x-slot>
    
    </x-subpages.model-form>

</x-app-layout>

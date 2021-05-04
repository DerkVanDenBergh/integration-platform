<x-app-layout>
    <x-slot name="header">
        {{ __('Authentication - create') }}
    </x-slot>

    <x-model-form :action="__('/connections/' . $connection . '/authentications')">

        <x-slot name="method">
            <input name="_method" type="hidden" value="POST">
        </x-slot>

        <x-slot name="fields">

            <div class="col-span-4">
                <x-input id="type" type="hidden" name="type" value="{{ $type }}" required autofocus />
            </div>

            <div class="col-span-4">
                <x-label for="title" :value="__('Name')" />

                <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
            </div>
            
            <div class="col-span-2">
                <x-label for="key" :value="__('API key')" />

                <x-input id="key" class="block mt-1 w-full" type="text" name="key" :value="old('key')" required autofocus />
            </div>
            
        </x-slot>
    
    </x-model-form>

</x-app-layout>

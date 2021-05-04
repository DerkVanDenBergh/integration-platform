<x-app-layout>
    <x-slot name="header">
        {{ __('Connection - create') }}
    </x-slot>

    

            <x-model-form :action="__('/connections')">

                <x-slot name="method">
                    <input name="_method" type="hidden" value="POST">
                </x-slot>

                <x-slot name="fields">

                    <div class="col-span-2">
                        <x-label for="title" :value="__('Name')" />

                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                    </div>

                    <div class="col-span-2">
                        <x-label for="base_url" :value="__('Base URL')" />

                        <x-input id="base_url" class="block mt-1 w-full" type="text" name="base_url" :value="old('base_url')" required autofocus />
                    </div>
                    
                    <div class="col-span-4">
                        <x-label for="description" :value="__('Description')" />

                        <x-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" autofocus />
                    </div>
                    
                </x-slot>
            
            </x-model-form>

    </div>
</x-app-layout>

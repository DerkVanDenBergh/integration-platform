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

            @can('manage_templates') 
                <!-- TODO redirect to /templates after activating this -->
                <div class="col-span-2">
                    <label for="template" class="inline-flex items-center">
                        <input id="template" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="template">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Connection template') }}</span>
                    </label>
                </div>
            @endcan
            
        </x-slot>
    
    </x-model-form>

</x-app-layout>

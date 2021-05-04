<x-app-layout>
    
    <x-slot name="header">
        {{ __('Connection - create from template') }}
    </x-slot>

    <x-model-form :action="__('/connections/create/template')">

        <x-slot name="method">
            <input name="_method" type="hidden" value="POST">
        </x-slot>

        <x-slot name="fields">

            <div class="col-span-2">
                <x-label for="title" :value="__('Name')" />

                <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
            </div>

            <div class="col-span-2">
                <x-label for="template_id" :value="__('Template')" />

                <x-select id="template_id" :value="__('id')" :label="__('title')" :options="$templates" class="block mt-1 w-full" name="template_id" required autofocus />
            </div>
            
        </x-slot>
    
    </x-model-form>

</x-app-layout>

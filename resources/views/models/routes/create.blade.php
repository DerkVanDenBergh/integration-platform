<x-app-layout>
    
    <x-slot name="header">
        {{ __('Route - create') }}
    </x-slot>

    <x-subpages.model-form :action="__('/routes')">

        <x-slot name="method">
            <input name="_method" type="hidden" value="POST">
        </x-slot>

        <x-slot name="fields">

            <div class="col-span-2">
                <x-forms.label for="title" :value="__('Name')" />

                <x-forms.input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="slug" :value="__('Slug')" />

                <x-forms.input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug')" required autofocus />
            </div>

            <div class="col-span-4">
                <x-forms.label for="description" :value="__('Description')" />

                <x-forms.input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required autofocus />
            </div>

        </x-slot>
    
    </x-subpages.model-form>

</x-app-layout>

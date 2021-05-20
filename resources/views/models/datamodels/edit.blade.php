<x-app-layout>
    <x-slot name="header">
        {{ __($model->title . ' - edit') }}
    </x-slot>

    
    <x-subpages.model-form :action="__('/models/') . $model->id">

        <x-slot name="method">
            <input name="_method" type="hidden" value="PUT">
        </x-slot>

        <x-slot name="fields">

            <div class="col-span-4">
                <x-forms.label for="title" :value="__('Name')" />

                <x-forms.input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $model->title }}" required autofocus />
            </div>
            
            <div class="col-span-4">
                <x-forms.label for="description" :value="__('Description')" />

                <x-forms.input id="description" class="block mt-1 w-full" type="text" name="description" value="{{ $model->description }}" autofocus />
            </div>
            
        </x-slot>
    
    </x-subpages.model-form>

</x-app-layout>

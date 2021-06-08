<x-app-layout>
    
    <x-slot name="header">
        {{ __($task->title . ' - edit') }}
    </x-slot>

    <x-forms.model-form :action="__('/tasks/') . $task->id">

        <x-slot name="method">
            <input name="_method" type="hidden" value="PUT">
        </x-slot>

        <x-slot name="fields">

            <div class="col-span-4">
                <x-forms.label for="title" :value="__('Name')" />

                <x-forms.input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $task->title }}" required autofocus />
            </div>

            <div class="col-span-4">
                <x-forms.label for="description" :value="__('Description')" />

                <x-forms.input id="description" class="block mt-1 w-full" type="text" name="description" value="{{ $task->description }}"  autofocus />
            </div>

            <div class="col-span-1">
                <label for="active" class="inline-flex items-center">
                    <input id="active" type="checkbox" @if($task->active) checked @endif class="rounded border-gray-300 text-green-400 shadow-sm focus:border-green-400 focus:ring focus:ring-green-200 focus:ring-opacity-50" name="active">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Active') }}</span>
                </label>
            </div>

        </x-slot>
    
    </x-forms.model-form>

</x-app-layout>

<x-app-layout>
    
    <x-slot name="header">
        {{ __($route->title . ' - view') }}
    </x-slot>

    <x-subpages.model-view :header="__('Details')" :model="$route" :resource="__('routes')">

        <x-slot name="fields">

            <div class="col-span-2">
                <x-forms.label for="title" :value="__('Name')" />

                <x-forms.input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $route->title }}" required disabled autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="slug" :value="__('Slug')" />

                <x-forms.input id="slug" class="block mt-1 w-full" type="text" name="slug" value="{{ $route->slug }}" required disabled autofocus />
            </div>

            <div class="col-span-4">
                <x-forms.label for="description" :value="__('Description')" />

                <x-forms.input id="description" class="block mt-1 w-full" type="text" name="description" value="{{ $route->description }}" required disabled autofocus />
            </div>

            <div class="col-span-1">
                <label for="active" class="inline-flex items-center">
                    <input id="active" type="checkbox" @if($route->active) checked @endif disabled class="rounded border-gray-300 text-green-400 shadow-sm focus:border-green-400 focus:ring focus:ring-green-200 focus:ring-opacity-50" name="can_manage_templates">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Active') }}</span>
                </label>
            </div>

        </x-slot>
    
    </x-subpages.model-view>

    <x-subpages.model-mapping :mapping="$mapping" :fields="$fields"></x-subpages.model-mapping>

</x-app-layout>

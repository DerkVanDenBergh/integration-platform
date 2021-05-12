<x-app-layout>
    
    <x-slot name="header">
        {{ __($role->title . ' - view') }}
    </x-slot>

    <x-model-view :model="$role" :resource="__('roles')">

        <x-slot name="fields">

            <div class="col-span-4">
                <x-label for="title" :value="__('Role name')" />

                <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $role->title }}" required disabled autofocus />
            </div>

            <div class="col-span-1">
                <label for="can_manage_users" class="inline-flex items-center">
                    <input id="can_manage_users" type="checkbox" @if($role->can_manage_users) checked @endif disabled class="rounded border-gray-300 text-green-500 shadow-sm focus:border-green-400 focus:ring focus:ring-green-200 focus:ring-opacity-50" name="can_manage_users">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Can manage users') }}</span>
                </label>
            </div>

            <div class="col-span-1">
                <label for="can_manage_roles" class="inline-flex items-center">
                    <input id="can_manage_roles" type="checkbox" @if($role->can_manage_roles) checked @endif disabled class="rounded border-gray-300 text-green-500 shadow-sm focus:border-green-400 focus:ring focus:ring-green-200 focus:ring-opacity-50" name="can_manage_roles">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Can manage roles') }}</span>
                </label>
            </div>

            <div class="col-span-1">
                <label for="can_manage_functions" class="inline-flex items-center">
                    <input id="can_manage_functions" type="checkbox" @if($role->can_manage_functions) checked @endif disabled class="rounded border-gray-300 text-green-500 shadow-sm focus:border-green-400 focus:ring focus:ring-green-200 focus:ring-opacity-50" name="can_manage_functions">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Can manage functions') }}</span>
                </label>
            </div>

            <div class="col-span-1">
                <label for="can_manage_templates" class="inline-flex items-center">
                    <input id="can_manage_templates" type="checkbox" @if($role->can_manage_templates) checked @endif disabled class="rounded border-gray-300 text-green-500 shadow-sm focus:border-green-400 focus:ring focus:ring-green-200 focus:ring-opacity-50" name="can_manage_templates">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Can manage templates') }}</span>
                </label>
            </div>

        </x-slot>
    
    </x-model-view>

</x-app-layout>

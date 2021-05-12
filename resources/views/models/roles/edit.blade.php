<x-app-layout>
    
    <x-slot name="header">
        {{ __($role->title . ' - edit') }}
    </x-slot>

    <x-model-form :action="__('/roles/') . $role->id">

        <x-slot name="method">
            <input name="_method" type="hidden" value="PUT">
        </x-slot>

        <x-slot name="fields">

            <div class="col-span-4">
                <x-label for="title" :value="__('Role name')" />

                <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $role->title }}" required autofocus />
            </div>

            <div class="col-span-1">
                <label for="can_manage_users" class="inline-flex items-center">
                    <input id="can_manage_users" type="checkbox" @if($role->can_manage_users) checked @endif class="rounded border-gray-300 text-green-400 shadow-sm focus:border-green-400 focus:ring focus:ring-green-200 focus:ring-opacity-50" name="can_manage_users">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Can manage users') }}</span>
                </label>
            </div>

            <div class="col-span-1">
                <label for="can_manage_roles" class="inline-flex items-center">
                    <input id="can_manage_roles" type="checkbox" @if($role->can_manage_roles) checked @endif  class="rounded border-gray-300 text-green-400 shadow-sm focus:border-green-400 focus:ring focus:ring-green-200 focus:ring-opacity-50" name="can_manage_roles">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Can manage roles') }}</span>
                </label>
            </div>

            <div class="col-span-1">
                <label for="can_manage_functions" class="inline-flex items-center">
                    <input id="can_manage_functions" type="checkbox" @if($role->can_manage_functions) checked @endif  class="rounded border-gray-300 text-green-400 shadow-sm focus:border-green-400 focus:ring focus:ring-green-200 focus:ring-opacity-50" name="can_manage_functions">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Can manage functions') }}</span>
                </label>
            </div>

            <div class="col-span-1">
                <label for="can_manage_templates" class="inline-flex items-center">
                    <input id="can_manage_templates" type="checkbox" @if($role->can_manage_templates) checked @endif  class="rounded border-gray-300 text-green-400 shadow-sm focus:border-green-400 focus:ring focus:ring-green-200 focus:ring-opacity-50" name="can_manage_templates">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Can manage templates') }}</span>
                </label>
            </div>

        </x-slot>
    
    </x-model-form>

</x-app-layout>

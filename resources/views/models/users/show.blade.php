<x-app-layout>
    <x-slot name="header">
        {{ __($user->title . ' - view') }}
    </x-slot>

    <x-subpages.model-view :model="$user" :resource="__('users')">

        <x-slot name="fields">

            <div class="col-span-4">
                <x-forms.label for="name" :value="__('Name')" />

                <x-forms.input id="name" class="block mt-1 w-full" type="text" name="title" value="{{ $user->name }}" required disabled autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="email" :value="__('E-mail')" />

                <x-forms.input id="email" class="block mt-1 w-full" type="text" name="email" value="{{ $user->email }}" required disabled autofocus />
            </div>

            <div class="col-span-2">
                <x-forms.label for="role_id" :value="__('Role')" />

                <x-forms.select id="role_id" :value="__('id')" :label="__('title')" :selected="$user->role_id" :options="$roles" class="block mt-1 w-full" name="role_id" required disabled autofocus />
            </div>

        </x-slot>
    
    </x-subpages.model-view>

</x-app-layout>

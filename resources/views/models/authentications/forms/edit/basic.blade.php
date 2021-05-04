<x-app-layout>
    
    <x-slot name="header">
        {{ __($authentication->title . ' - edit') }}
    </x-slot>

    <x-model-form :action="__('/connections/' . $authentication->connection_id . '/authentications/' . $authentication->id)">

        <x-slot name="method">
            <input name="_method" type="hidden" value="PUT">
        </x-slot>

        <x-slot name="fields">

            <div class="col-span-4">
                <x-input id="type" type="hidden" name="type" value="{{ $authentication->type }}" required autofocus />
            </div>

            <div class="col-span-4">
                <x-label for="title" :value="__('Name')" />

                <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $authentication->title }}" required autofocus />
            </div>
            
            <div class="col-span-2">
                <x-label for="username" :value="__('Username')" />

                <x-input id="username" class="block mt-1 w-full" type="text" name="username" value="{{ $authentication->username }}" required autofocus />
            </div>

            <div class="col-span-2">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" value="{{ $authentication->password }}" required autofocus />
            </div>
            
        </x-slot>
    
    </x-model-form>

</x-app-layout>

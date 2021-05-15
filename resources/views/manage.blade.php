<x-app-layout>
    <x-slot name="header">
        {{ __('Manage') }}
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-2 gap-6">
            @can('manage_users')
                <x-buttons.action-card>
                    <x-slot name="title">
                        Users
                    </x-slot>

                    <x-slot name="description">
                        Control who has access to this application. Maybe reset their password too.
                    </x-slot>

                    <x-slot name="link">
                        /users
                    </x-slot>
                </x-buttons.action-card>
            @endcan
            @can('manage_roles')
                <x-buttons.action-card>
                    <x-slot name="title">
                        User roles
                    </x-slot>

                    <x-slot name="description">
                        For ensuring the right eyes can see the right information.
                    </x-slot>

                    <x-slot name="link">
                        /roles
                    </x-slot>
                </x-buttons.action-card>
            @endcan
            @can('manage')
                <x-buttons.action-card>
                    <x-slot name="title">
                        Logs
                    </x-slot>

                    <x-slot name="description">
                        Check the logs. Hey, something has to break if you wait long enough, right?
                    </x-slot>

                    <x-slot name="link">
                        /logs
                    </x-slot>
                </x-buttons.action-card>
            @endcan
            @can('manage_templates')
                <x-buttons.action-card>
                    <x-slot name="title">
                        Templates
                    </x-slot>

                    <x-slot name="description">
                        Connection templates. Put in some work so you can save some work when saving some work on your normal work.
                    </x-slot>

                    <x-slot name="link">
                        /templates
                    </x-slot>
                </x-buttons.action-card>
            @endcan
        </div>
    </div>
</x-app-layout>

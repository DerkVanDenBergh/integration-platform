<x-app-layout>
    <x-slot name="header">

    </x-slot>
    
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-2 gap-6">

            <x-views.components.dashboard-card :caption="__('Check \'em out')" :link="__('/users')" :span="__(2)"> 'mostActiveUser', 'amountOfRoutes', 'amountOfTasks', 'mostActiveProcessable'
                
                <x-slot name="title">
                    {{ $mostActiveUser }}
                </x-slot>

                <x-slot name="description">
                    Most active user in the past 24 hours. Give them a pat on the back.
                </x-slot>

            </x-views.components.dashboard-card>

            <x-views.components.dashboard-card :caption="__('See how yours did')" :link="__('/routes')" :span="__(1)">

                <x-slot name="title">
                    {{ $amountOfRoutes }}
                </x-slot>

                <x-slot name="description">
                    Amount of routes executed in the past 24 hours. That's a lot!
                </x-slot>

            </x-views.components.dashboard-card>

            <x-views.components.dashboard-card :caption="__('See how yours did')" :link="__('/tasks')" :span="__(1)">

                <x-slot name="title">
                    {{ $amountOfTasks }}
                </x-slot>

                <x-slot name="description">
                    Amount of tasks executed in the past 24 hours. That should shave a couple from your to-do list.
                </x-slot>

            </x-views.components.dashboard-card>

            <x-views.components.dashboard-card :caption="__('Configure')" :link="__('/routes')" :span="__(2)">

                <x-slot name="title">
                    {{ $mostActiveProcessable }}
                </x-slot>

                <x-slot name="description">
                    The task or route with the most executions in the last 24 hours. That is some real automation right there!
                </x-slot>

            </x-views.components.dashboard-card>

</x-app-layout>

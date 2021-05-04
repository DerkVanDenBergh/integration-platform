<x-card>

    <x-slot name="content">
        
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ $action }}">
            @csrf

            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-2">
                    <x-label for="option" :value="__('What would you like to do?')" />

                    <x-select id="option" :value="$value" :label="$label" :options="$options" class="block mt-1 w-full" name="option" required autofocus />
                </div>
            </div>


            <div class="flex items-center justify-end">
                <x-button class="ml-3">
                    {{ __('Next') }}
                </x-button>
            </div>
        </form>

    </x-slot>
    
</x-card>
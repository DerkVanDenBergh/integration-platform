<x-subpages.card>

    <x-slot name="content">
        
        <!-- Session Status -->
        <x-session.auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-session.auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ $action }}">
            @csrf

            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-2">
                    <x-forms.label for="option" :value="__($header ?? 'What would you like to do?')" />

                    <x-forms.select id="option" :value="$value" :label="$label" :options="$options" class="block mt-1 w-full" name="option" required autofocus />
                </div>
            </div>


            <div class="flex items-center justify-end">
                <x-buttons.button class="ml-3">
                    {{ __('Next') }}
                </x-buttons.button>
            </div>
        </form>

    </x-slot>
    
</x-subpages.card>
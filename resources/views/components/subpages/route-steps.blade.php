<div class="py-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

        @if($header ?? false)
            <h2 class="font-semibold text-l text-green-400 leading-tight pb-3">
                {{ $header }}
            </h2>
        @endif

        @if($form ?? false)

            <form method="POST" action="{{ $action ?? ''}}">
                @csrf

                <!-- Session Status -->
                <x-session.auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-session.auth-validation-errors class="mb-4" :errors="$errors" />

                <div class="px-2" id="stepTable">
                    @if($steps->count() > 0)
                        @foreach ($steps as $step)
                            <x-subpages.components.route-step-form :number="$loop->index" :step="$step" :route="$route" :functions="$functions" :function="$step->step_function()->first()" :parameters="$step->step_function()->first()->step_function_parameters()->get()" :arguments="$step->arguments()->orderBy('parameter_id')->get()"></x-subpages.components.route-step-form>
                        @endforeach

                    @else
                        <x-alerts.model-empty id="noStepsAlert">
                
                            <x-slot name="customAlert">
                                <div>
                                    <p class="font-bold">No steps defined yet...</p>
                                    <p class="text-sm">Click on 'add step' below to get started!</p>
                                </div>
                            </x-slot>

                        </x-alerts.model-empty>

                    @endif
                </div>

                <x-buttons.button class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition font-bold py-2 px-4 rounded inline-block items-center text-white mr-2">
                    <x-icons.svg-check class="h-5 w-5 mr-2"></x-icons.svg-check>
                    {{ __('Save') }}
                </x-buttons.button>

                <a href="#" id="addElementButton" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                    <x-icons.svg-plus class="h-5 w-5 mr-2"></x-icons.svg-plus>
                    <span>Add step</span>
                </a>

            </form>

        @else

            @if($steps->count() > 0)

                <x-alerts.model-info>
                
                    <x-slot name="customAlert">
                        <div>
                            <p class="font-bold">Did you know?</p>
                            <p class="text-sm">You can use the values of fields and earlier steps in your steps! To do so, you need to write them in a special manner. 
                                @if($inputModelFields ?? false)
                                    A couple of examples for your route:
                                    <div class="inline-block sm:rounded-lg bg-gray-200 px-1.5 pb-0.5 mr-1 mt-1"> 
                                        ![{{ $inputModelFields[0]->name }}]
                                    </div>
                                    @if($inputModelFields->count() > 1)
                                        <div class="inline-block sm:rounded-lg bg-gray-200 px-1.5 pb-0.5 mr-1 mt-1"> 
                                            ![{{ $inputModelFields[1]->name }}]
                                        </div>
                                    @endif
                                @else
                                    A couple of examples:
                                    <div class="inline-block sm:rounded-lg bg-gray-200 px-1.5 pb-0.5 mr-1 mt-1"> 
                                        ![id]
                                    </div>
                                    <div class="inline-block sm:rounded-lg bg-gray-200 px-1.5 pb-0.5 mr-1 mt-1"> 
                                        ![name]
                                    </div>
                                @endif
                            </p>
                        </div>
                    </x-slot>

                </x-alerts.model-info>

                <div class="px-2">
                    @foreach ($steps as $step)
                        <x-subpages.components.route-step :step="$step"></x-subpages.components.route-step>
                    @endforeach
                </div>

                <a href="/routes/{{ $route->id }}/steps" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                    <x-icons.svg-edit class="h-5 w-5 mr-2"></x-icons.svg-edit>
                    <span>Edit steps</span>
                </a>
            
            @else

                <x-alerts.model-empty>
                    
                    <x-slot name="customAlert">
                        <div>
                            <p class="font-bold">No steps defined yet...</p>
                            <p class="text-sm">Don't worry, some routes don't need a lot of steps to reach the destination!</p>
                        </div>
                    </x-slot>

                </x-alerts.model-empty>

                <a href="/routes/{{ $route->id }}/steps" class="mt-5 bg-gray-100 hover:bg-green-400 hover:text-white transition text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                    <x-icons.svg-plus class="h-5 w-5 mr-2"></x-icons.svg-plus>
                    <span>Add steps</span>
                </a>
                
            @endif
        @endif
    </div>
    @if($form ?? false)
        @section('page-scripts')
            <script>
                $("#stepTable").sortable().disableSelection();
            </script>
            <script>
                $(document).ready(function(){
                    $(document).on("click", "select option", function () {
                        var optionSelected    = $(this);
                        var valueSelected     = optionSelected.val();
                        var textSelected      = optionSelected.text();
                        var stepId            = $(this).closest(".step-container").attr('id');

                        var argumentContainer = $(this).closest(".step-container").find(".argument-container");
                        
                        argumentContainer.empty();

                        var functions         = {!! json_encode($functions) !!};

                        var result            = functions.find(f => f.id === parseInt(valueSelected));
                        var counter           = 1;

                        result.step_function_parameters.forEach(parameter => {

                            if(parameter.is_nullable) {
                                requiredText = 'required="required"';
                            } else {
                                requiredText = "";
                            }
                            
                            argumentInputHtml = '<div class="col-span-2 py-4">' +
                                                    '<label class="block font-medium text-sm text-gray-700" for="steps[' + stepId + '][arguments][' + parameter.id + ']">' +
                                                        'Parameter ' + counter + ': ' + parameter.name + 
                                                    '</label>' +
                                                    '<input class="rounded-md shadow-sm border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 disabled:bg-gray-600 block mt-1 w-full" id="steps[' + stepId + '][arguments][' + parameter.id + ']" type="text" name="steps[' + stepId + '][arguments][' + parameter.id + ']" ' + requiredText + ' autofocus="autofocus">' +
                                                '</div>';
                            
                            argumentContainer.append(argumentInputHtml);

                            counter++;
                        })
                    });

                    $(document).on("click", "#addElementButton", function() {
                        var stepTable         = $("#stepTable");
                        var stepId            = Math.floor((Math.random() * 10000000000) + 1); // Generate a random number, because its less of a hassle than trying to find an untaken step id

                        $('#noStepsAlert').remove();

                        $.ajax({
                            url: "{{ url('/routes/' . $route->id . '/steps/component')}}",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            data: {
                                'number': stepId
                            },
                            method: 'POST',
                            success: function (data) {
                                var response = jQuery.parseJSON(data);
                                stepTable.append(response.view);
                            }
                        });
                    });

                    $(document).on('click', '.delete-button', function() {
                        var stepContainer     = $(this).closest('.step-container');
                        stepContainer.remove();
                    });
                });
            </script>
        @endsection
    @endif
</div>

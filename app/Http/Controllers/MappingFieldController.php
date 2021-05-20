<?php

namespace App\Http\Controllers;

use App\Models\MappingField;
use Illuminate\Http\Request;

use App\Models\Route;
use App\Models\Mapping;

use App\Services\DataModelFieldService;
use App\Services\MappingFieldService;
use App\Services\EndpointService;
use App\Services\DataModelService;
use App\Services\StepService;

class MappingFieldController extends Controller
{

    protected $modelFieldService;
    protected $mappingFieldService;
    protected $endpointService;
    protected $modelService;
    protected $stepService;

    public function __construct(
        DataModelFieldService $modelFieldService,
        MappingFieldService $mappingFieldService,
        EndpointService $endpointService,
        DataModelService $modelService,
        StepService $stepService
    ) {
        $this->modelFieldService = $modelFieldService;
        $this->mappingFieldService = $mappingFieldService;
        $this->endpointService = $endpointService;
        $this->modelService = $modelService;
        $this->stepService = $stepService;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MappingField  $mappingField
     * @return \Illuminate\Http\Response
     */
    public function edit(Route $route, Mapping $mapping)
    {
        // TODO Look if i can rework this. A bit of a mess
        if($mapping->type == 'route') {
            $availableFields = $this->modelFieldService->findAllAttributesFromModel($mapping->input_model);
            $availableSteps = $this->stepService->findAllStepsWithReturnValueFromRoute($route->id);

            $availableFields->map(function ($field) {
                $field['field_type'] = 'model';
                return $field;
            });

            $availableSteps->map(function ($step) {
                $step['field_type'] = 'step';
                return $step;
            });

            $availableFields = $availableFields->concat($availableSteps);
        } else {
            // TODO make this compatible with tasks and input_endpoint
            $availableFields = $this->modelFieldService->findAllAttributesFromModel($mapping->input_model);
        }

        $availableFields->prepend((object) ['id' => '', 'name' => '', 'field_type' => '']);

        $outputEndpoint = $this->endpointService->findById($mapping->output_endpoint);

        $outputModel = $this->modelService->findById($outputEndpoint->model_id);

        $fields = $this->modelFieldService->findAllFromModel($outputModel->id);
        
        return view('models.mappingfields.edit', compact('route', 'mapping', 'availableFields', 'fields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MappingField  $mappingField
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Route $route, Mapping $mapping)
    {
        $validatedData = $request->validate([
            'fields' => ['required']
        ]);

        $this->mappingFieldService->deleteAllFromMapping($mapping->id);

        // TODO very ugly, needs rework
        foreach ($validatedData['fields'] as $key => $value) {
            if($value != '-') {
                $this->mappingFieldService->store([
                    'mapping_id' => $mapping->id,
                    'output_field' => $key,
                    'input_field' => explode('-', $value)[0],
                    'input_field_type' => explode('-', $value)[1]
                ]);
            }
        }

        return redirect('/routes/' . $route->id)->with('success', 'Mapping of route with name "' . $route->title . '" has succesfully been updated!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Mapping;
use Illuminate\Http\Request;

use App\Models\Processable;

use App\Services\MappingService;
use App\Services\EndpointService;
use App\Services\DataModelService;

class MappingController extends Controller
{

    protected $mappingService;
    protected $endpointService;
    protected $modelService;

    public function __construct(
        MappingService $mappingService,
        EndpointService $endpointService,
        DataModelService $modelService
    ) {
        $this->mappingService = $mappingService;
        $this->endpointService = $endpointService;
        $this->modelService = $modelService;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mapping  $mapping
     * @return \Illuminate\Http\Response
     */
    public function edit(Processable $processable, Mapping $mapping)
    {
        $endpoints = $this->endpointService->findAllFromUser(auth()->user()->id);

        $models = $this->modelService->findAllFromUser(auth()->user()->id);

        return view('models.mappings.edit', compact('processable', 'mapping', 'endpoints', 'models'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mapping  $mapping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Processable $processable, Mapping $mapping)
    {
        $validatedData = $request->validate([
            'input_model' => ['nullable'],
            'input_endpoint' => ['required_without:input_model'],
            'output_endpoint' => ['required']
        ]);

        $this->mappingService->update($validatedData, $mapping);

        return redirect("/{$processable->processableType()}s/" . $processable->id)->with('success', 'Mapping of processable with name "' . $processable->title . '" has succesfully been updated!');

    }
}

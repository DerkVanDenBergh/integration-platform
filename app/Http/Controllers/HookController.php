<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\HookService;
use App\Services\ProcessableService;
use App\Services\MappingService;
use App\Services\DataModelService;
use App\Services\LogService;
use App\Services\RunService;
use App\Services\StepService;

use App\Exceptions\BreakOnStepFunctionException;
use App\Exceptions\StepFunctionNotFoundException;

use App\Jobs\LogProcessable;

class HookController extends Controller
{
    protected $hookService;
    protected $processableService;
    protected $mappingService;
    protected $modelService;
    protected $logService;
    protected $runService;
    protected $stepService;

    public function __construct(
        HookService $hookService, 
        ProcessableService $processableService,
        MappingService $mappingService,
        DataModelService $modelService,
        LogService $logService,
        RunService $runService, 
        StepService $stepService
    ) {
        $this->hookService = $hookService;
        $this->processableService = $processableService;
        $this->mappingService = $mappingService;
        $this->modelService = $modelService;
        $this->logService = $logService;
        $this->runService = $runService;
        $this->stepService = $stepService;
    }

    public function get()
    {

    }

    public function post(Request $request, $slug)
    {
        $processable = $this->processableService->findBySlug($slug); 

        if(!$processable->active) {
            return response()->json([
                'error' => 'processable is not active.'
            ], 400);
        }

        $this->hookService->validateAuthentication($processable, $request); 

        $mapping = $this->mappingService->findByProcessableId($processable->id);

        $data = $this->hookService->validateInputModel($mapping, $request->toArray());

        if($data == []) {
            LogProcessable::dispatchAfterResponse($processable, 'processable', 'failure', json_encode($request->toArray()), 'error: input data not compatible with processable.', $this->logService, $this->runService);

            return response()->json([
                'error' => 'input data not compatible with processable.'
            ], 400);
        }

        try {

            $data = $this->stepService->processSteps($processable, $data);

            $output_model = $this->hookService->fillOutputModel($mapping, $data);

            $response = $this->hookService->sendModelToEndpoint($output_model, $mapping);

            LogProcessable::dispatchAfterResponse($processable, 'processable', 'success', json_encode($request), json_encode($output_model), $this->logService, $this->runService);
        } catch (BreakOnStepFunctionException $e){
            $response =  response()->json([
                'status' => 'aborted'
            ], 200);

            LogProcessable::dispatchAfterResponse($processable, 'processable', 'aborted', json_encode($request), 'error: ' . $e->getMessage(), $this->logService, $this->runService);
        } catch (StepFunctionNotFoundException | Exception $e) {
            $response =  response()->json([
                'error' => $e->getMessage()
            ], 400);

            LogProcessable::dispatchAfterResponse($processable, 'processable', 'failure', json_encode($request), 'error: ' . $e->getMessage(), $this->logService, $this->runService);
        } 

        return $response;
    }

    public function put()
    {

    }

    public function patch()
    {

    }

    public function delete()
    {

    }
}
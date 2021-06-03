<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\HookService;
use App\Services\RouteService;
use App\Services\MappingService;
use App\Services\DataModelService;
use App\Services\LogService;
use App\Services\RunService;
use App\Services\StepService;

use App\Jobs\LogRoute;

class HookController extends Controller
{
    protected $hookService;
    protected $routeService;
    protected $mappingService;
    protected $modelService;
    protected $logService;
    protected $runService;
    protected $stepService;

    public function __construct(
        HookService $hookService, 
        RouteService $routeService,
        MappingService $mappingService,
        DataModelService $modelService,
        LogService $logService,
        RunService $runService, 
        StepService $stepService
    ) {
        $this->hookService = $hookService;
        $this->routeService = $routeService;
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
        $route = $this->routeService->findBySlug($slug); 

        if(!$route->active) {
            return response()->json([
                'error' => 'route is not active.'
            ], 400);
        }

        $this->hookService->validateAuthentication($route, $request); 

        $mapping = $this->mappingService->findByRouteId($route->id);

        $data = $this->hookService->validateInputModel($mapping, $request->toArray());

        if($data == []) {
            LogRoute::dispatchAfterResponse($route, 'route', 'failure', json_encode($data), '', $this->logService, $this->runService);

            return response()->json([
                'error' => 'input data not compatible with route.'
            ], 400);
        }

        $data = $this->stepService->processSteps($route, $data);

        $output_model = $this->hookService->fillOutputModel($mapping, $data);

        try {
            $response = $this->hookService->sendModelToEndpoint($output_model, $mapping);

            LogRoute::dispatchAfterResponse($route, 'route', 'success', json_encode($data), json_encode($output_model), $this->logService, $this->runService);
        } catch (exception $e) {
            $response =  response()->json([
                'error' => $e->getMessage();
            ], 400);

            LogRoute::dispatchAfterResponse($route, 'route', 'failure', json_encode($data), 'error:' + $e->getMessage(), $this->logService, $this->runService);
        } finally {
            return $response;
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
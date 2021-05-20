<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

use App\Models\Route;
use App\Services\RouteService;
use App\Services\MappingService;
use App\Services\MappingFieldService;
use App\Services\DataModelService;
use App\Services\DataModelFieldService;
use App\Services\EndpointService;
use App\Services\StepService;
use App\Services\RunService;

class RouteController extends Controller
{

    protected $routeService;
    protected $mappingService;
    protected $modelFieldService;
    protected $mappingFieldService;
    protected $modelService;
    protected $endpointService;
    protected $stepService;
    protected $runService;

    public function __construct(
        RouteService $routeService,
        MappingService $mappingService,
        MappingFieldService $mappingFieldService,
        DataModelFieldService $modelFieldService,
        DataModelService $modelService,
        EndpointService $endpointService,
        StepService $stepService,
        RunService $runService
    ) {
        $this->routeService = $routeService;
        $this->mappingService = $mappingService;
        $this->modelFieldService = $modelFieldService;
        $this->mappingFieldService = $mappingFieldService;
        $this->modelService = $modelService;
        $this->endpointService = $endpointService;
        $this->stepService = $stepService;
        $this->runService = $runService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = $this->routeService->findAllFromUser(auth()->user()->id);

        return view('models.routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('models.routes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', Rule::unique('routes')->where('user_id', auth()->user()->id), 'max:255'],
            'description' => ['nullable']
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        $route = $this->routeService->store($validatedData);

        return redirect('/routes')->with('success', 'Route with name "' . $route->title . '" has succesfully been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function show(Route $route)
    {
        Gate::authorize('mutate_or_view_route', $route);

        $mapping = $this->mappingService->findByRouteId($route->id);

        $mappingFields = $this->mappingFieldService->findAllFromMapping($mapping->id);

        $models = $this->modelService->findAllFromUser(auth()->user()->id);

        $endpoints = $this->endpointService->findAllFromUser(auth()->user()->id);

        $steps = $this->stepService->findAllFromRoute($route->id);

        $runs = $this->runService->findAllFromRoute($route->id);

        if($mapping->output_endpoint != null) {
            $outputEndpoint = $this->endpointService->findById($mapping->output_endpoint);

            $outputModel = $this->modelService->findById($outputEndpoint->model_id);

            $outputModelFields = $this->modelFieldService->findAllFromModel($outputModel->id);

            $inputModel = $this->modelService->findById($mapping->input_model);

            $inputModelFields = $this->modelFieldService->findAllFromModel($inputModel->id);

            return view(
                'models.routes.show', 
                compact(
                    'route', 
                    'mapping', 
                    'mappingFields',
                    'models', 
                    'endpoints',
                    'steps',
                    'outputModel',
                    'outputModelFields',
                    'inputModel',
                    'inputModelFields', 
                    'runs'
                )
            );
        }

        return view(
            'models.routes.show', 
            compact(
                'route', 
                'mapping', 
                'mappingFields',
                'models', 
                'endpoints',
                'steps', 
                'runs'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function edit(Route $route)
    {
        Gate::authorize('mutate_or_view_route', $route);

        return view('models.routes.edit', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Route $route)
    {
        Gate::authorize('mutate_or_view_route', $route);

        $validatedData = $request->validate([
            'title' => ['required', Rule::unique('routes')->where('user_id', auth()->user()->id)->ignore($route->id), 'max:255'],
            'description' => ['nullable'],
            'active' => ['nullable']
        ]);

        // TODO: make sure the route cant be set to active if one of the endpoints in the mapping is not filled

        $route = $this->routeService->update($validatedData, $route);

        return redirect('/routes/' . $route->id)->with('success', 'Route with name ' . $route->title . ' has successfully been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function destroy(Route $route)
    {
        Gate::authorize('mutate_or_view_route', $route);

        $this->routeService->delete($route);

        return redirect('/routes')->with('success', 'Route with name "' . $route->title . '" has succesfully been deleted!');
    }
}

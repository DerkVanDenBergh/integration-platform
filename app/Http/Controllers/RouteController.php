<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

use App\Models\Route;
use App\Services\RouteService;
use App\Services\MappingService;
use App\Services\MappingFieldService;

class RouteController extends Controller
{

    protected $routeService;
    protected $mappingService;
    protected $fieldService;

    public function __construct(
        RouteService $routeService,
        MappingService $mappingService,
        MappingFieldService $fieldService
    ) {
        $this->routeService = $routeService;
        $this->mappingService = $mappingService;
        $this->fieldService = $fieldService;
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
            'description' => ['nullable'],
            'slug' => ['required', 'max:255']
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

        $fields = $this->fieldService->findAllFromMapping($mapping->id);

        return view('models.routes.show', compact('route', 'mapping', 'fields'));
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
            'active' => ['nullable'],
            'slug' => ['required', 'max:255']
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

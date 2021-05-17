<?php

namespace App\Services;

use App\Models\Route;

class RouteService
{
    protected $mappingService;

    public function __construct(MappingService $mappingService) {
        $this->mappingService = $mappingService;
    }

    public function store(array $data)
    {
        $route = Route::create($data);

        // Checkboxes dont work too well with laravel

        $route->active = array_key_exists('active', $data);

        $route->save();

        $this->mappingService->createMappingForRoute($route->id);

        return $route;
    }

    public function update(array $data, Route $route)
    {
        $route->update($data);

        // Checkboxes dont work too well with laravel

        $route->active = array_key_exists('active', $data);

        $route->save();

        return $route;
    }

    public function delete(Route $route)
    {
       $route->delete();

       return $route;
    }

    public function findById($id)
    {
       $route = Route::find($id);

       return $route;
    }

    public function findAll()
    {
       $routes = Route::all();

       return $routes;
    }

    public function findAllFromUser($id)
    {
        $routes = Route::where('user_id', $id)->get();

        return $routes;
    }
}

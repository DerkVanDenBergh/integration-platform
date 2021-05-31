<?php

namespace App\Services;

use App\Models\Route;

use Illuminate\Support\Str;
use App\Services\LogService;

class RouteService
{
    protected $mappingService;
    protected $logService;

    public function __construct(MappingService $mappingService,  LogService $logService) {
        $this->mappingService = $mappingService;
        $this->logService = $logService;
    }

    public function store(array $data)
    {
        $data['active'] = array_key_exists('active', $data);
        $data['slug'] = Str::random(25);
        
        $route = Route::create($data);
    
        $route->save();

        $this->mappingService->createMappingForRoute($route->id);

        $this->logService->push('info','created route with id ' . $route->id . '.', json_encode($route));

        return $route;
    }

    public function update(array $data, Route $route)
    {
        $data['active'] = array_key_exists('active', $data);

        $route->update($data);

        $route->save();

        $this->logService->push('info','updated route with id ' . $route->id . '.', json_encode($route));

        return $route;
    }

    public function delete(Route $route)
    {
       $route->delete();

       $this->logService->push('info','deleted route with id ' . $route->id . '.', json_encode($route));

       return $route;
    }

    public function findById($id)
    {
        $route = Route::find($id);

        if($route) {
            $this->logService->push('info','requested route with id ' . $route->id . '.', json_encode($route));
        } else {
            $this->logService->push('warning','requested route with id ' . $id . ' but was not found.');
        }

        return $route;
    }

    public function findBySlug($slug)
    {
        $route = Route::where('slug', $slug)->first();

        if($route) {
            $this->logService->push('info','requested route with slug ' . $slug . '.', json_encode($route));
        } else {
            $this->logService->push('warning','requested route with slug ' . $slug . ' but was not found.');
        }

        return $route;
    }

    public function findAll()
    {
       $routes = Route::all();

       $this->logService->push('info','requested all routes.', json_encode($routes));

       return $routes;
    }

    public function findAllFromUser($id)
    {
        $routes = Route::where('user_id', $id)->get();

        $this->logService->push('info','requesteed all routes associated with user with id ' . $id . '.');

        return $routes;
    }
}

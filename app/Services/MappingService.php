<?php

namespace App\Services;

use App\Models\Mapping;

use App\Services\LogService;

class MappingService
{
    protected $logService;

    public function __construct(
        LogService $logService
    ) {
        $this->logService = $logService;
    }
    
    public function store(array $data, $type)
    {
        $mapping = Mapping::create($data);

        $mapping->save();

        $this->logService->push('info','created mapping with id ' . $mapping->id . '.', json_encode($mapping));

        return $mapping;
    }

    public function update(array $data, Mapping $mapping)
    {
        $mapping->update($data);

        $this->logService->push('info','updated mapping with id ' . $mapping->id . '.', json_encode($mapping));

        return $mapping;
    }

    public function delete(Mapping $mapping)
    {
       $mapping->delete();

       $this->logService->push('info','deleted mapping with id ' . $mapping->id . '.', json_encode($mapping));

       return $mapping;
    }

    public function findById($id)
    {
       $mapping = Mapping::find($id);

       $this->logService->push('info','requested mapping with id ' . $mapping->id . '.', json_encode($mapping));

       return $mapping;
    }

    public function findAll()
    {
       $mappings = Mapping::all();

       $this->logService->push('info','requested all mappings.');

       return $mappings;
    }

    public function findAllFromUser($id)
    {
        $mappings = Mapping::where('user_id', $id)->get();

        $this->logService->push('info','requested all mappings associated with user with id ' . $id . '.');

        return $mappings;
    }

    public function findByRouteId($id)
    {
       $mapping = Mapping::where('route_id', $id)->first();

       return $mapping;
    }

    public function createMappingForRoute($id)
    {
        $mapping = new Mapping();

        $mapping->route_id = $id;
        $mapping->type = 'route';

        $mapping->save();

        return $mapping;
    }
}

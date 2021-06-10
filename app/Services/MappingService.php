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
    
    public function store(array $data)
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

        if($mapping) {
            $this->logService->push('info','requested mapping with id ' . $mapping->id . '.', json_encode($mapping));
        } else {
            $this->logService->push('warning','requested mapping with id ' . $id . ' but was not found.');
        }

        return $mapping;
    }

    public function findAll()
    {
       $mappings = Mapping::all();

       $this->logService->push('info','requested all mappings.');

       return $mappings;
    }

    public function findByProcessableId($id)
    {
       $mapping = Mapping::where('processable_id', $id)->first();

        if($mapping) {
            $this->logService->push('info','requested mapping from processable with id ' . $mapping->processable_id . '.', json_encode($mapping));
        } else {
            $this->logService->push('warning','requested mapping from processable with id ' . $id . ' but was not found.');
        }


       return $mapping;
    }
}

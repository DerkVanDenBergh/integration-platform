<?php

namespace App\Services;

use App\Models\Mapping;

class MappingService
{
    public function store(array $data)
    {
        $mapping = Mapping::create($data);

        $mapping->save();

        return $mapping;
    }

    public function update(array $data, Mapping $mapping)
    {
        $mapping->update($data);

        return $mapping;
    }

    public function delete(Mapping $mapping)
    {
       $mapping->delete();

       return $mapping;
    }

    public function findById($id)
    {
       $mapping = Mapping::find($id);

       return $mapping;
    }

    public function findAll()
    {
       $mappings = Mapping::all();

       return $mappings;
    }

    public function findAllFromUser($id)
    {
        $mappings = Mapping::where('user_id', $id)->get();

        return $mappings;
    }

    public function findByRouteId($id)
    {
       $mapping = Mapping::where('route_id', $id)->first();

       return $mapping;
    }

    public function createMappingForRoute($id)
    {
        $mapping = Mapping::create([
            'route_id' => $id
        ]);

        $mapping->save();

        return $mapping;
    }
}

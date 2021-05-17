<?php

namespace App\Services;

use App\Models\DataModel;
use App\Models\MappingField;

class MappingFieldService
{
    public function store(array $data)
    {
        $mappingField = MappingField::create($data);

        $mappingField->save();

        return $mappingField;
    }

    public function update(array $data, MappingField $mappingField)
    {
        $mappingField->update($data);

        return $mappingField;
    }

    public function delete(MappingField $mappingField)
    {
       $mappingField->delete();

       return $mappingField;
    }

    public function findById($id)
    {
       $mappingField = MappingField::find($id);

       return $mappingField;
    }

    public function findAll()
    {
       $mappingFields = MappingField::all();

       return $mappingFields;
    }

    public function findAllFromMapping($id)
    {

        $mappingFields = MappingField::where('mapping_id', $id)->get();

        return $mappingFields;
    }
}

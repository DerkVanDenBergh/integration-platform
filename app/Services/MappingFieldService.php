<?php

namespace App\Services;

use App\Models\DataModel;
use App\Models\DataModelField;
use App\Models\MappingField;


class MappingFieldService
{
    protected $logService;

    public function __construct(
        LogService $logService
    ) {
        $this->logService = $logService;
    }
    
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
        $mappingFields = MappingField::where('mapping_id', $id)
                                        ->addSelect(['field_name' => DataModelField::select('name')
                                        ->whereColumn('input_field', 'data_model_fields.id')
                                        ->limit(1)])
                                    ->get();

        return $mappingFields;
    }

    public function findByMappingAndOutputFieldId($mapping_id, $field_id)
    {
        $mappingField = MappingField::where('mapping_id', $mapping_id)->where('output_field', $field_id)->first();
                                        
        return $mappingField;
    }

    public function deleteAllFromMapping($id)
    {
        $mappingFields = MappingField::where('mapping_id', $id)->get();
        
        foreach($mappingFields as $mappingField) {
            $this->delete($mappingField);
        }
    }
}

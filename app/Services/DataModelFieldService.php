<?php

namespace App\Services;

use App\Models\DataModel;
use App\Models\DataModelField;

class DataModelFieldService
{
    protected $logService;

    public function __construct(
        LogService $logService
    ) {
        $this->logService = $logService;
    }
    
    public function store(array $data)
    {
        $dataModelField = DataModelField::create($data);

        $dataModelField->save();

        return $dataModelField;
    }

    public function update(array $data, DataModelField $dataModelField)
    {
        $dataModelField->update($data);

        return $dataModelField;
    }

    public function delete(DataModelField $dataModelField)
    {
       $dataModelField->delete();

       return $dataModelField;
    }

    public function findById($id)
    {
       $dataModelField = DataModelField::find($id);

       return $dataModelField;
    }

    public function findAll()
    {
       $dataModelFields = DataModelField::all();

       return $dataModelFields;
    }

    public function findAllFromModel($id)
    {
        $dataModelFields = DataModelField::where('model_id', $id)->whereNull('parent_id')->get();

        return $dataModelFields;
    }

    public function findAllParentsFromModel($id)
    {

        $dataModelFields = DataModelField::where('model_id', $id)->whereIn('node_type', ['set', 'array'])->get();

        return $dataModelFields;
    }

    public function findAllFieldNamesFromModel($id)
    {
        $dataModelFields = DataModelField::where('model_id', $id)->pluck('name');

        return $dataModelFields;
    }

    public function findAllAttributesFromModel($id)
    {
        $dataModelFields = DataModelField::where('model_id', $id)->where('node_type', 'attribute')->get();

        return $dataModelFields;
    }

    public function createFieldsFromDefinition($definition, $dataModel)
    {
        // TODO: create functionality to interate through JSON to get model structure

        return null;
    }

    public function getDataTypes()
    {
        $options = collect([
            (object) [
                'option' => '',
                'label' => ''
            ],
            (object) [
                'option' => 'integer',
                'label' => 'Number'
            ],
            (object) [
                'option' => 'string',
                'label' => 'Text'
            ],
            (object) [
                'option' => 'decimal',
                'label' => 'Decimal'
            ],
            (object) [
                'option' => 'date',
                'label' => 'Date'
            ]
        ]);

        return $options;
    }

    public function getNodeTypes()
    {
        $options = collect([
            (object) [
                'option' => 'attribute',
                'label' => 'Attribute'
            ],
            (object) [
                'option' => 'set',
                'label' => 'Set'
            ],
            // TODO Make this supported in logic
            //(object) [
            //    'option' => 'array',
            //    'label' => 'List'
            //]
        ]);

        return $options;
    }
}

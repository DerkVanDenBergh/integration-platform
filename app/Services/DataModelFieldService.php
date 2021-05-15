<?php

namespace App\Services;

use App\Models\DataModel;
use App\Models\DataModelField;

class DataModelFieldService
{
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
            (object) [
                'option' => 'array',
                'label' => 'List'
            ]
        ]);

        return $options;
    }
}

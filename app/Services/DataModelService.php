<?php

namespace App\Services;

use App\Models\DataModel;

class DataModelService
{
    public function store(array $data)
    {
        $dataModel = DataModel::create($data);

        $dataModel->save();

        return $dataModel;
    }

    public function update(array $data, DataModel $dataModel)
    {
        $dataModel->update($data);

        return $dataModel;
    }

    public function delete(DataModel $dataModel)
    {
       $dataModel->delete();

       return $dataModel;
    }

    public function findById($id)
    {
       $dataModel = DataModel::find($id);

       return $dataModel;
    }

    public function findAll()
    {
       $dataModels = DataModel::all();

       return $dataModels;
    }

    public function findAllFromUser($id)
    {

        $dataModels = DataModel::where('user_id', auth()->user()->id)->get();

        return $dataModels;
    }

    public function getOptions()
    {
        $options = collect([
            (object) [
                'option' => 'definition',
                'label' => 'Create a model from a JSON definition'
            ],
            (object) [
                'option' => 'create',
                'label' => 'Create a model from scratch'
            ]
        ]);

        return $options;
    }
}

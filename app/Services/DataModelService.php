<?php

namespace App\Services;

use App\Models\DataModel;
use App\Models\Mapping;
use App\Models\Endpoint;

use App\Services\LogService;

class DataModelService
{
    protected $logService;

    public function __construct(
        LogService $logService
    ) {
        $this->logService = $logService;
    }
    
    public function store(array $data)
    {
        $dataModel = DataModel::create($data);

        $dataModel->save();

        $this->logService->push('info','created datamodel with id ' . $dataModel->id . '.', json_encode($dataModel));

        return $dataModel;
    }

    public function update(array $data, DataModel $dataModel)
    {
        $dataModel->update($data);

        $this->logService->push('info','updated datamodel with id ' . $dataModel->id . '.', json_encode($dataModel));

        return $dataModel;
    }

    public function delete(DataModel $dataModel)
    {
       $dataModel->delete();

       $this->logService->push('info','deleted datamodel with id ' . $dataModel->id . '.', json_encode($dataModel));

       return $dataModel;
    }

    public function findById($id)
    {
       $dataModel = DataModel::find($id);

        if($dataModel) {
            $this->logService->push('info','requested dataModel with id ' . $dataModel->id . '.', json_encode($dataModel));
        } else {
            $this->logService->push('warning','requested dataModel with id ' . $id . ' but was not found.');
        }

       return $dataModel;
    }

    public function findAll()
    {
       $dataModels = DataModel::all();

       $this->logService->push('info','requested all datamodels.');

       return $dataModels;
    }

    public function findAllFromUser($id)
    {
        $dataModels = DataModel::where('user_id', $id)->get();

        $this->logService->push('info','requested all datamodels associated with user with id ' . $id . '.');

        return $dataModels;
    }

    public function findInputModelByMappingId($id)
    {
        // TODO Is a service call, make it a service call
        $mapping = Mapping::find($id);

        if($mapping->input_model) {
            $model = DataModel::find($mapping->input_model);
        } else {
            // TODO same goes here
            $endpoint = Endpoint::find($mapping->input_endpoint);

            $model = DataModel::find($endpoint->model_id);
        }

        return $model;
    }

    public function findOutputModelByMappingId($id)
    {
        // TODO Is a service call, make it a service call
        $mapping = Mapping::find($id);

        // TODO same goes here
        $endpoint = Endpoint::find($mapping->output_endpoint);

        $model = DataModel::find($endpoint->model_id);

        return $model;
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

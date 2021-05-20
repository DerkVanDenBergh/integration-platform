<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HookService
{

    protected $routeService;
    protected $mappingService;
    protected $modelService;
    protected $mappingFieldService;
    protected $modelFieldService;
    protected $endpointService;

    public function __construct(
        RouteService $routeService,
        MappingService $mappingService,
        DataModelService $modelService,
        MappingFieldService $mappingFieldService,
        DataModelFieldService $modelFieldService,
        EndpointService $endpointService
    ) {
        $this->routeService = $routeService;
        $this->mappingService = $mappingService;
        $this->modelService = $modelService;
        $this->mappingFieldService = $mappingFieldService;
        $this->modelFieldService = $modelFieldService;
        $this->endpointService = $endpointService;
    }

    public function validateAuthentication($route, $data)
    {
        // TODO check for authentication on requests
    }

    public function validateInputModel($mapping, $data)
    {
        $model = $this->modelService->findInputModelByMappingId($mapping->id);

        $modelFields = $this->modelFieldService->findAllFieldNamesFromModel($model->id)->toArray();

        foreach($data as $key => $value) {
            if(!in_array($key, $modelFields)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    public function fillOutputModel($mapping, $data)
    {
        $model = $this->modelService->findOutputModelByMappingId($mapping->id);

        $modelFields = $this->modelFieldService->findAllFromModel($model->id);

        $model = $this->populateModelFields($modelFields, $mapping, $data);

        return $model;
    }

    private function populateModelFields($modelFields, $mapping, $requestFields)
    {
        $model = [];

        foreach($modelFields as $modelField) {
            if($modelField->node_type == 'attribute') {
                
                $model[$modelField->name] = $this->getMatchedValue($modelField, $mapping, $requestFields);

            } else {
                $children = $this->populateModelFields($modelField->children()->get(), $mapping, $requestFields);

                $model[$modelField->name] = $children;
            }
        }

        return $model;
    }

    private function getMatchedValue($field, $mapping, $requestFields)
    {
        $fieldMapping = $this->mappingFieldService->findByMappingAndOutputFieldId($mapping->id, $field->id);

        $inputField = $this->modelFieldService->findById($fieldMapping->input_field);

        $reference = $this->array_access($requestFields, $this->getFullKeyPath($inputField));

        return $reference;
    }

    private function getFullKeyPath($field)
    {
        $key = [];

        array_push($key, $field->name);
        
        $field = $field->parent()->first();

        while($field != null) {
            array_push($key, $field->name);

            $field = $field->parent()->first();
        }

        return array_reverse($key);
    }

    private function array_access(&$array, $keys) {

        if ($keys) {
            $key = array_shift($keys);
    
            $sub = $this->array_access(
                $array[$key],
                $keys
            );
    
            return $sub;
        } else {
            return $array;
        }
    }

    public function sendModelToEndpoint($model, $mapping)
    {
        $endpoint = $this->endpointService->findById($mapping->output_endpoint);

        $url = $this->endpointService->getUrlById($endpoint->id);

        $authentication = $endpoint->authentication()->first();

        switch ($authentication->type) {
            case "Basic":
                $response = Http::withBasicAuth($authentication->username, $authentication->password)
                    ->post($url, $model);
                break;
            case "Key":
                $response = Http::withToken($authentication->key)
                    ->post($url, $model);
                break;
            case "Token":
                $response = Http::withToken($authentication->token)
                    ->post($url, $model);
                break;
        }

        return $response;
    }
}
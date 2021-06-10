<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class RequestService
{
    protected $mappingService;
    protected $modelService;
    protected $mappingFieldService;
    protected $modelFieldService;
    protected $endpointService;
    protected $stepService;

    public function __construct(
        MappingService $mappingService,
        DataModelService $modelService,
        MappingFieldService $mappingFieldService,
        DataModelFieldService $modelFieldService,
        EndpointService $endpointService,
        StepService $stepService
    ) {
        $this->mappingService = $mappingService;
        $this->modelService = $modelService;
        $this->mappingFieldService = $mappingFieldService;
        $this->modelFieldService = $modelFieldService;
        $this->endpointService = $endpointService;
        $this->stepService = $stepService;
    }

    public function validateAuthentication($processable, $data)
    {
        // TODO check for authentication on requests
        return true;
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
                
                $value = $this->getMatchedValue($modelField, $mapping, $requestFields);
                
                if($value) {
                    $model[$modelField->name] = $value;
                }

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

        if($fieldMapping) {
            if($fieldMapping->input_field_type == 'model') {
                $inputField = $this->modelFieldService->findById($fieldMapping->input_field);

                $path = $this->getFullKeyPath($inputField);
            } else {
                $step = $this->stepService->findById($fieldMapping->input_field);

                $path = [$step->name];
            }

            $reference = $this->array_access($requestFields, $path);

            return $reference;
        } else {
            return '';
        }
    }

    private static function getFullKeyPath($field)
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

    private static function array_access(&$array, $keys) {

        if ($keys) {
            $key = array_shift($keys);
    
            $sub = self::array_access(
                $array[$key],
                $keys
            );
    
            return $sub;
        } else {
            return $array;
        }
    }

    private function sendRequest($endpoint, $authentication, $model = [])
    {
        $url = 'https://' . $this->endpointService->getUrlById($endpoint->id);

        if($authentication) {
            switch (strtoupper($authentication->type)) {
                case "BASIC":
                    $client = Http::withBasicAuth($authentication->username, $authentication->password);
                    break;
                case "OAUTH1":

                    $stack = HandlerStack::create();

                    $middleware = new Oauth1([
                        'consumer_key'    => $authentication->oauth1_consumer_key,
                        'consumer_secret' => $authentication->oauth1_consumer_secret,
                        'token'           => $authentication->oauth1_token,
                        'token_secret'    => $authentication->oauth1_token_secret
                    ]);

                    $stack->push($middleware);

                    $client = new Client([
                        'base_uri' => $url,
                        'handler' => $stack,
                        'auth' => 'oauth'
                    ]);

                    // Now you don't need to add the auth parameter
                    $url = '?' . http_build_query(self::rawurlencode_array($model));
                    $model = [];

                    break;
                case "TOKEN":
                    $client = Http::withToken($authentication->token);
                    break;
            }
        } else {
            $client = Http::timeout(7);
        }

        switch(strtoupper($endpoint->method)) {
            case "GET":
                $model ? $response = $client->get($url, $model) : $response = $client->get($url);
                break;

            case "POST":
                $model ? $response = $client->post($url, $model) : $response = $client->post($url);
                break;

            case "PUT":
                $model ? $response = $client->put($url, $model) : $response = $client->put($url);
                break;

            case "DELETE":
                $model ? $response = $client->delete($url, $model) : $response = $client->delete($url);
                break;

            default:
                $model ? $response = $client->get($url, $model) : $response = $client->get($url);
        }
        
        return $response;
    }

    public function sendModelToEndpoint($model, $mapping)
    {
        $endpoint = $this->endpointService->findById($mapping->output_endpoint);

        $authentication = $endpoint->authentication()->first();

        $response = $this->sendRequest($endpoint, $authentication, $model);

        return $response;
    }

    public function retrieveModelFromEndpoint($mapping)
    {
        $endpoint = $this->endpointService->findById($mapping->input_endpoint);

        $authentication = $endpoint->authentication()->first();

        $response = $this->sendRequest($endpoint, $authentication);

        return $response;
    }

    private static function rawurlencode_array($array) 
    {
        foreach($array as $key=>$value) {
            if(is_array($value)) {
                $key = rawurlencode($key);
                $value = self::rawurlencode_array($value);
                ksort($value);
            } else {
                $key = rawurlencode($key);
                $value = rawurlencode($value);
            }
        }

        ksort($array);

        return $array;
    }
}
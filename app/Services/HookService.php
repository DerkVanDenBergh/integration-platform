<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class HookService
{
    protected $processableService;
    protected $mappingService;
    protected $modelService;
    protected $mappingFieldService;
    protected $modelFieldService;
    protected $endpointService;
    protected $stepService;

    public function __construct(
        ProcessableService $processableService,
        MappingService $mappingService,
        DataModelService $modelService,
        MappingFieldService $mappingFieldService,
        DataModelFieldService $modelFieldService,
        EndpointService $endpointService,
        StepService $stepService
    ) {
        $this->processableService = $processableService;
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

    public function sendModelToEndpoint($model, $mapping)
    {
        $endpoint = $this->endpointService->findById($mapping->output_endpoint);

        $url = 'https://' . $this->endpointService->getUrlById($endpoint->id);

        $authentication = $endpoint->authentication()->first();

        if($authentication) {

            switch (strtoupper($authentication->type)) {
                case "BASIC":
                    $response = Http::withBasicAuth($authentication->username, $authentication->password)
                        ->post($url, $model);
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
                    $response = $client->post('?' . http_build_query(self::rawurlencode_array($model)));

                    break;
                case "TOKEN":
                    $response = Http::withToken($authentication->token)
                        ->post($url, $model);
                    break;
                
            }
        } else {
            $response = Http::post($url, $model);
        }
        
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
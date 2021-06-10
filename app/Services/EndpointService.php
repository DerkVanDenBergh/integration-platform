<?php

namespace App\Services;

use App\Models\Endpoint;
use App\Models\Connection;

use App\Services\LogService;

class EndpointService
{
    protected $logService;

    public function __construct(
        LogService $logService
    ) {
        $this->logService = $logService;
    }
    
    public function store(array $data)
    {
        $endpoint = Endpoint::create($data);

        $endpoint->save();

        $this->logService->push('info','created endpoint with id ' . $endpoint->id . '.', json_encode($endpoint));

        return $endpoint;
    }

    public function update(array $data, Endpoint $endpoint)
    {
        $endpoint->update($data);

        $this->logService->push('info','updated endpoint with id ' . $endpoint->id . '.', json_encode($endpoint));

        return $endpoint;
    }

    public function updateModel($model_id, Endpoint $endpoint)
    {
        $endpoint->model_id = $model_id;

        $endpoint->save();

        $this->logService->push('info','updated the model for endpoint with id ' . $endpoint->id . '.', json_encode($endpoint));

        return $endpoint;
    }

    public function delete(Endpoint $endpoint)
    {
       $endpoint->delete();

       $this->logService->push('info','deleted endpoint with id ' . $endpoint->id . '.', json_encode($endpoint));

       return $endpoint;
    }

    public function findById($id)
    {
        $endpoint = Endpoint::find($id);

        if($endpoint) {
            $this->logService->push('info','requested endpoint with id ' . $endpoint->id . '.', json_encode($endpoint));
        } else {
            $this->logService->push('warning','requested endpoint with id ' . $id . ' but was not found.');
        }

        return $endpoint;
    }

    public function findAll()
    {
       $endpoints = Endpoint::all();

       $this->logService->push('info','requested all endpoints');

       return $endpoints;
    }

    public function findAllFromConnection($id)
    {
        $endpoints = Endpoint::where('connection_id', $id)->get();

        $this->logService->push('info','requested all endpoints associated with connection with id ' . $id . '.');

        return $endpoints;
    }

    public function findAllFromUser($id)
    {
        // TODO: is a service call, make it a service call
        $connections = Connection::select('id')->where('user_id', $id)->get();

        $authentications = Endpoint::whereIn('connection_id', $connections)
                                            ->addSelect(['connection_name' => Connection::select('title')
                                                ->whereColumn('connection_id', 'connections.id')
                                                ->limit(1)])
                                            ->get();

        $this->logService->push('info','requested all endpoints associated with user with id ' . $id . '.');

        return $authentications;
    }

    public function getUrlById($id)
    {
        $endpoint = Endpoint::find($id);

        if($endpoint) {
            $connection = $endpoint->connection()->first();

            return $connection->base_url . $endpoint->endpoint;
        } else {
            return null;
        }
    }

    public function getProtocols()
    {
        $options = collect([
            (object) [
                'option' => 'HTTP',
                'label' => 'Create a HTTP endpoint'
            ],
            (object) [
                'option' => 'TCP',
                'label' => 'Create a TCP endpoint'
            ]
        ]);

        return $options;
    }

    public function getMethods($type)
    {
        switch (strtolower($type)) {
            case 'http':
                $options = collect([
                    (object) [
                        'option' => 'GET'
                    ],
                    (object) [
                        'option' => 'UPDATE'
                    ],
                    (object) [
                        'option' => 'POST'
                    ]
                    ,
                    (object) [
                        'option' => 'DELETE'
                    ]
                ]);
                break;
            case 'tcp':
                $options = collect([
                    (object) [
                        'option' => 'Receive'
                    ],
                    (object) [
                        'option' => 'Send'
                    ]
                ]);
                break;
            default:
               // TODO: throw error
               break;
        }

        return $options;
    }

    public function formatEndpointUrl($endpoint)
    {
        if($endpoint[0] != '/') {
            $endpoint = '/' . $endpoint;
        }

        $endpoint = rtrim($endpoint, '/');

        return $endpoint;
    }
}

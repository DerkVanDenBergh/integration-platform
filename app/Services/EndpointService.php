<?php

namespace App\Services;

use App\Models\Endpoint;

class EndpointService
{
    public function store(array $data)
    {
        $endpoint = Endpoint::create($data);

        $endpoint->save();

        return $endpoint;
    }

    public function update(array $data, Endpoint $endpoint)
    {
        $endpoint->update($data);

        return $endpoint;
    }

    public function updateModel($model_id, Endpoint $endpoint)
    {
        $endpoint->model_id = $model_id;

        $endpoint->save();

        return $endpoint;
    }

    public function delete(Endpoint $endpoint)
    {
       $endpoint->delete();

       return $endpoint;
    }

    public function findById($id)
    {
       $endpoint = Endpoint::find($id);

       return $endpoint;
    }

    public function findAll()
    {
       $endpoints = Endpoint::all();

       return $endpoints;
    }

    public function findAllFromConnection($id)
    {
        $endpoints = Endpoint::where('connection_id', $id)->get();

        return $endpoints;
    }

    public function findAllFromUser($id)
    {
        $connections = Connection::select('id')->where('user_id', $id)->get();

        $endpoints = Endpoint::whereIn('connection_id', $connections)->get();

        return $endpoints;
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
                        'option' => 'Reveive'
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
            return null;
        }

        $endpoint = rtrim($endpoint, '/');

        return $endpoint;
    }
}

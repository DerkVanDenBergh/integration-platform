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
}

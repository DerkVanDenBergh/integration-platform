<?php

namespace App\Services;

use App\Models\Connection;

class ConnectionService
{
    public function store(array $data)
    {
        $connection = Connection::create($data);

        $connection->save();

        return $connection;
    }

    public function update(array $data, Connection $connection)
    {
        $connection->update($data);

        $connection->save();

        return $connection;
    }

    public function delete(Connection $connection)
    {
       $connection->delete();

       return $connection;
    }

    public function findById($id)
    {
       $connection = Connection::find($id);

       return $connection;
    }

    public function findAll()
    {
       $connections = Connection::all();

       return $connections;
    }

    public function findAllFromUser($id)
    {
        $connections = Connection::where('user_id', $id)->get();

        return $connections;
    }
}

<?php

namespace App\Services;

use App\Models\Authentication;
use App\Models\Connection;

class AuthenticationService
{
    public function store(array $data)
    {
        $authentication = Authentication::create($data);

        $authentication->save();

        return $authentication;
    }

    public function update(array $data, Authentication $authentication)
    {
        $authentication->update($data);

        return $authentication;
    }

    public function delete(Authentication $authentication)
    {
       $authentication->delete();

       return $authentication;
    }

    public function findById($id)
    {
       $authentication = Authentication::find($id);

       return $authentication;
    }

    public function findAll()
    {
       $authentications = Authentication::all();

       return $authentications;
    }

    public function findAllFromConnection($id)
    {
        $authentications = Authentication::where('connection_id', $id)->get();

        return $authentications;
    }

    public function findAllFromUser($id)
    {
        $connections = Connection::select('id')->where('user_id', $id)->get();

        $authentications = Authentication::whereIn('connection_id', $connections)
                                            ->addSelect(['connection_name' => Connection::select('title')
                                                ->whereColumn('connection_id', 'connections.id')
                                                ->limit(1)])
                                            ->get();

        return $authentications;
    }

    public function getAuthTypes()
    {
        $options = collect([
            (object) [
                'option' => 'Key',
                'label' => 'Create an API key authentication.'
            ],
            (object) [
                'option' => 'Token',
                'label' => 'Create an API token authentication.'
            ],
            (object) [
                'option' => 'Basic',
                'label' => 'Create an username and password authentication.'
            ]
        ]);

        return $options;
    }
}

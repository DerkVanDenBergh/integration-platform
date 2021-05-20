<?php

namespace App\Services;

use App\Models\Authentication;
use App\Models\Connection;

use App\Services\LogService;

class AuthenticationService
{

    protected $logService;

    public function __construct(
        LogService $logService
    ) {
        $this->logService = $logService;
    }

    public function store(array $data)
    {
        $authentication = Authentication::create($data);

        $authentication->save();

        $this->logService->push('info','created authentication with id ' . $authentication->id . '.', json_encode($authentication));

        return $authentication;
    }

    public function update(array $data, Authentication $authentication)
    {
        $authentication->update($data);

        $this->logService->push('info','updated authentication with id ' . $authentication->id . '.', json_encode($authentication));

        return $authentication;
    }

    public function delete(Authentication $authentication)
    {
       $authentication->delete();

       $this->logService->push('info','deleted authentication with id ' . $authentication->id . '.', json_encode($authentication));

       return $authentication;
    }

    public function findById($id)
    {
       $authentication = Authentication::find($id);

       $this->logService->push('info','requested authentication with id ' . $authentication->id . '.', json_encode($authentication));

       return $authentication;
    }

    public function findAll()
    {
       $authentications = Authentication::all();

       $this->logService->push('info','requested all authentications.');

       return $authentications;
    }

    public function findAllFromConnection($id)
    {
        $authentications = Authentication::where('connection_id', $id)->get();

        $this->logService->push('info','requested all authentications from connection with id ' . $id . '.');

        return $authentications;
    }

    public function findAllFromUser($id)
    {
        // TODO: is a service call, make it a service call
        $connections = Connection::select('id')->where('user_id', $id)->get();

        $authentications = Authentication::whereIn('connection_id', $connections)
                                            ->addSelect(['connection_name' => Connection::select('title')
                                                ->whereColumn('connection_id', 'connections.id')
                                                ->limit(1)])
                                            ->get();
        
        $this->logService->push('info','requested all authentications assosiated with user with id ' . $id . '.');

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

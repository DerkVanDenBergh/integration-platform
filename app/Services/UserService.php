<?php

namespace App\Services;

use App\Models\User;

use App\Services\LogService;

class UserService
{
    protected $logService;

    public function __construct(
        LogService $logService
    ) {
        $this->logService = $logService;
    }
    
    public function store(array $data)
    {
        $user = User::create($data);

        $this->logService->push('info','created user with id ' . $user->id . '.', json_encode($user));

        return $user;
    }

    public function update(array $data, User $user)
    {
        $user->update($data);

        $this->logService->push('info','updated user with id ' . $user->id . '.', json_encode($user));

        return $user;
    }

    public function delete(User $user)
    {
       $user->delete();

       $this->logService->push('info','deleted user with id ' . $user->id . '.', json_encode($user));

       return $user;
    }

    public function findById($id)
    {
       $user = User::find($id);

       $this->logService->push('info','requested user with id ' . $user->id . '.', json_encode($user));

       return $user;
    }

    public function findAll()
    {
       $users = User::all();

       $this->logService->push('info','requested all users.');

       return $users;
    }
}

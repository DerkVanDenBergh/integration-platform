<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function store(array $data)
    {
        $user = User::create($data);

        return $user;
    }

    public function update(array $data, User $user)
    {
        $user->update($data);

        return $user;
    }

    public function delete(User $user)
    {
       $user->delete();

       return $user;
    }

    public function findById($id)
    {
       $user = User::find($id);

       return $user;
    }

    public function findAll()
    {
       $users = User::all();

       return $users;
    }
}

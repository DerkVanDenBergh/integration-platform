<?php

namespace App\Services;

use App\Models\Log;

class LogService
{
    public function store(array $data)
    {
        $log = Log::create($data);

        $log->save();

        return $log;
    }

    public function update(array $data, Log $log)
    {
        $log->update($data);

        $log->save();

        return $log;
    }

    public function delete(Role $role)
    {
       $role->delete();

       return $role;
    }

    public function findById($id)
    {
       $role = Role::find($id);

       return $role;
    }

    public function findAll()
    {
       $roles = Role::all();

       return $roles;
    }
}
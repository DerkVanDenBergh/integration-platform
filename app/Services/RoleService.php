<?php

namespace App\Services;

use App\Models\Role;

use App\Services\LogService;

class RoleService
{
    protected $logService;

    public function __construct(
        LogService $logService
    ) {
        $this->logService = $logService;
    }
    
    public function store(array $data)
    {
        $role = Role::create($data);

        // Checkboxes dont work to well with laravel

        $role->can_manage_users = array_key_exists('can_manage_users', $data);
        $role->can_manage_roles = array_key_exists('can_manage_roles', $data);
        $role->can_manage_functions = array_key_exists('can_manage_functions', $data);
        $role->can_manage_templates= array_key_exists('can_manage_templates', $data);
        $role->save();

        $this->logService->push('info','created role with id ' . $role->id . '.', json_encode($role));

        return $role;
    }

    public function update(array $data, Role $role)
    {
        $role->update($data);

        // Checkboxes dont work to well with laravel

        $role->can_manage_users = array_key_exists('can_manage_users', $data);
        $role->can_manage_roles = array_key_exists('can_manage_roles', $data);
        $role->can_manage_functions = array_key_exists('can_manage_functions', $data);
        $role->can_manage_templates = array_key_exists('can_manage_templates', $data);

        $role->save();

        $this->logService->push('info','updated role with id ' . $role->id . '.', json_encode($role));

        return $role;
    }

    public function delete(Role $role)
    {
       $role->delete();

       $this->logService->push('info','deleted role with id ' . $role->id . '.', json_encode($role));

       return $role;
    }

    public function findById($id)
    {
        $role = Role::find($id);

        if($role) {
            $this->logService->push('info','requested role with id ' . $role->id . '.', json_encode($role));
        } else {
            $this->logService->push('warning','requested role with id ' . $id . ' but was not found.');
        }
        
        return $role;
    }

    public function findAll()
    {
       $roles = Role::all();

       $this->logService->push('info','requested all roles.');

       return $roles;
    }
}

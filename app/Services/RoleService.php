<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    public function store(array $data)
    {
        $role = Role::create($data);

        // Checkboxes dont work to well with laravel

        $role->can_manage_users = array_key_exists('can_manage_users', $data);
        $role->can_manage_roles = array_key_exists('can_manage_roles', $data);
        $role->can_manage_functions = array_key_exists('can_manage_functions', $data);

        $role->save();

        return $role;
    }

    public function update(array $data, Role $role)
    {
        $role->update($data);

        // Checkboxes dont work to well with laravel

        $role->can_manage_users = array_key_exists('can_manage_users', $data);
        $role->can_manage_roles = array_key_exists('can_manage_roles', $data);
        $role->can_manage_functions = array_key_exists('can_manage_functions', $data);

        $role->save();

        return $role;
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

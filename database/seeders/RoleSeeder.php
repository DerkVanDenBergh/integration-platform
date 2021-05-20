<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role($this->definition(1001, 'Administrator', true, true, true, true));
        $admin->save();
    }

    private function definition($id, $title, $users, $functions, $roles, $templates)
    {
        $parameters = [
            'id' => $id,
            'title' => $title, 
            'can_manage_users' => $users,
            'can_manage_functions' => $functions,
            'can_manage_roles' => $roles,
            'can_manage_templates' => $templates
        ];

        return $parameters;
    }
}

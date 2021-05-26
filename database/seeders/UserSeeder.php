<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $system = new User($this->definition(1, 'System', 'system', 'disabled', 1001));
    
        $system->save();

        $admin = new User($this->definition(1002, 'Mintegration Admin', 'admin@mintegration.com', '$2y$12$ohqbjLwZ5GOADWvAiyLt..xvMgEWkhCEZB9vBkKtaIBJVvHenr/l6', 1001));
    
        $admin->save();
    }

    private function definition($id, $name, $email, $password, $role)
    {
        $parameters = [
            'id' => $id,
            'name' => $name, 
            'email' => $email,
            'password' => $password,
            'role_id' => $role
        ];

        return $parameters;
    }
}

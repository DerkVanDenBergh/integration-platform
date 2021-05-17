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
        $admin = new User($this->definition(1002, 'Derk van den Bergh', 'derk@test.nl', '$2y$12$ohqbjLwZ5GOADWvAiyLt..xvMgEWkhCEZB9vBkKtaIBJVvHenr/l6', 1001));
    
        $admin->save();

        \Illuminate\Support\Facades\DB::statement("ALTER SEQUENCE users_id_seq RESTART 11000;");
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

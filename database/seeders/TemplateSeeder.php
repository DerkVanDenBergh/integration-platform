<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Connection;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    }

    private function definition($id, $title, $type, $username, $password, $key, $token, $connection_id)
    {
        $parameters = [
            'id' => $id,
            'title' => $title,
            'type' => $type,
            'username' => $username,
            'password' => $password,
            'key' => $key,
            'token' => $token,
            'connection_id' => $connection_id
        ];

        return $parameters;
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Endpoint;

class EndpointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_post = new Endpoint($this->definition(
            1000, 
            'Add new user', 
            '/user', 
            'HTTP',
            'POST',
            1000,
            1000
        ));

        $user_post->save();

        $users_get = new Endpoint($this->definition(
            1001, 
            'Get all users', 
            '/users', 
            'HTTP',
            'GET',
            1000,
            1000
        ));
        
        $users_get->save();
        
        $employee_post = new Endpoint($this->definition(
            1002, 
            'Add new employee', 
            '/employee', 
            'HTTP',
            'POST',
            1001,
            1001
        ));

        $employee_post->save();

        $employee_get = new Endpoint($this->definition(
            1003, 
            'Get all employees', 
            '/employees', 
            'HTTP',
            'GET',
            1001,
            1001
        ));
        
        $employee_get->save();

        \Illuminate\Support\Facades\DB::statement("ALTER SEQUENCE endpoints_id_seq RESTART 11000;");
    }

    private function definition($id, $title, $endpoint, $protocol, $method, $connection_id, $model_id)
    {
        $parameters = [
            'id' => $id,
            'title' => $title,
            'endpoint' => $endpoint,
            'protocol' => $protocol,
            'method' => $method,
            'connection_id' => $connection_id,
            'model_id' => $model_id
        ];

        return $parameters;
    }


}

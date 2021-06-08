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
            2000, 
            'Add new user', 
            '/user', 
            'HTTP',
            'POST',
            2000,
            2000,
            2000
        ));

        $user_post->save();

        $users_get = new Endpoint($this->definition(
            2001, 
            'Get all users', 
            '/users', 
            'HTTP',
            'GET',
            2000,
            2000,
            2000
        ));
        
        $users_get->save();
        
        $employee_post = new Endpoint($this->definition(
            2002, 
            'Add new employee', 
            '/employee', 
            'HTTP',
            'POST',
            2001,
            2001,
            2001
        ));

        $employee_post->save();

        $employee_get = new Endpoint($this->definition(
            2003, 
            'Get all employees', 
            '/employees', 
            'HTTP',
            'GET',
            2001,
            2001,
            2001
        ));
        
        $employee_get->save();
    }

    private function definition($id, $title, $endpoint, $protocol, $method, $connection_id, $authentication_id, $model_id)
    {
        $parameters = [
            'id' => $id,
            'title' => $title,
            'endpoint' => $endpoint,
            'protocol' => $protocol,
            'method' => $method,
            'connection_id' => $connection_id,
            'authentication_id' => $authentication_id,
            'model_id' => $model_id
        ];

        return $parameters;
    }


}

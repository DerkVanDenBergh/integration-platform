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
        $endpoint_http_post = new Endpoint($this->definition(
            1000, 
            'Add new user', 
            '/user', 
            'http',
            'post',
            1000
        ));
        
        $endpoint_http_post->save();
        
        $endpoint_http_get = new Endpoint($this->definition(
            1001, 
            'Get users', 
            '/users', 
            'http',
            'get',
            1000
        ));

        $endpoint_http_get->save();
    }

    private function definition($id, $title, $endpoint, $protocol, $method, $connection_id)
    {
        $parameters = [
            'id' => $id,
            'title' => $title,
            'endpoint' => $endpoint,
            'protocol' => $protocol,
            'method' => $method,
            'connection_id' => $connection_id
        ];

        return $parameters;
    }


}

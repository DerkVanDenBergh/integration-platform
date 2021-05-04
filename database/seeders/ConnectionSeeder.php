<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Connection;

class ConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $beeceptor_a = new Connection($this->definition(1000, 'Beeceptor 1', 'A connection to a beeceptor endpoint', 'https://integration-platform.free.beeceptor.com', 1002));
        $beeceptor_a->save();
        
        $beeceptor_b = new Connection($this->definition(1001, 'Beeceptor 2', 'A connection to a beeceptor endpoint', 'https://integration-platform-2.free.beeceptor.com', 1002));
        $beeceptor_b->save();
    }

    private function definition($id, $title, $description, $base_url, $user_id)
    {
        $parameters = [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'base_url' => $base_url,
            'user_id' => $user_id
        ];

        return $parameters;
    }
}

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
        $beeceptor_user_management = new Connection($this->definition(
            1000, 
            'Beeceptor User Management', 
            'A connection to Mintegration Beeceptor User Management', 
            'https://mintegration-user-management.free.beeceptor.com', 
            1002, 
            false
        ));

        $beeceptor_user_management->save();
        
        $beeceptor_b = new Connection($this->definition(
            1001, 
            'Beeceptor Employee Management', 
            'A connection to Mintegration Beeceptor Employee Management', 
            'https://mintegration-employee-management.free.beeceptor.com', 
            1002, 
            false
        ));

        $beeceptor_b->save();
    }

    private function definition($id, $title, $description, $base_url, $user_id, $template)
    {
        $parameters = [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'base_url' => $base_url,
            'user_id' => $user_id,
            'template' => $template
        ];

        return $parameters;
    }
}

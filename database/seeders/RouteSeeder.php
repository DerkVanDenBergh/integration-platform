<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Route;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $beeceptor_user_to_beeceptor_employee = new Route($this->definition(
            1000, 
            'Beeceptor User -> Beeceptor Employee', 
            'A route to integrate a user model from Beeceptor User Management to Beeceptor Employee Management.', 
            true, 
            '/usermanagement/addUser',
            1002
        ));

        $beeceptor_user_to_beeceptor_employee->save();

        \Illuminate\Support\Facades\DB::statement("ALTER SEQUENCE routes_id_seq RESTART 11000;");
    }

    private function definition($id, $title, $description, $active, $slug, $user_id)
    {
        $parameters = [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'active' => $active,
            'slug' => $slug,
            'user_id' => $user_id
        ];

        return $parameters;
    }
}

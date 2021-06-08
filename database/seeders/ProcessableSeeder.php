<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Processable;

class ProcessableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $beeceptor_user_to_beeceptor_employee = new Processable($this->definition(
            2000, 
            Processable::ROUTE,
            'Beeceptor User -> Beeceptor Employee', 
            'A route to integrate a user model from Beeceptor User Management to Beeceptor Employee Management.', 
            true, 
            '85jGeLxPQbXDqrpsp6CZis6tg',
            1002
        ));

        $beeceptor_user_to_beeceptor_employee->save();
    }

    private function definition($id, $type_id, $title, $description, $active, $slug, $user_id)
    {
        $parameters = [
            'id' => $id,
            'type_id' => $type_id,
            'title' => $title,
            'description' => $description,
            'active' => $active,
            'slug' => $slug,
            'user_id' => $user_id
        ];

        return $parameters;
    }
}

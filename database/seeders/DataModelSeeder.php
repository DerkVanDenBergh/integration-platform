<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\DataModel;

class DataModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model_user = new DataModel($this->definition(
            1000, 
            'User',
            'A model for a MBUM user', 
            1002
        ));
        
        $model_user->save();

        $model_employee = new DataModel($this->definition(
            1001, 
            'Employee',
            'A model for a MBEM employee', 
            1002
        ));
        
        $model_employee->save();
    }

    private function definition($id, $title, $description, $user_id, $template_id = null)
    {
        $parameters = [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'user_id' => $user_id,
            'template_id' => $template_id
        ];

        return $parameters;
    }
}

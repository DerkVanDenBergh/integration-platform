<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Mapping;

class MappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $beeceptor_user_to_beeceptor_employee_mapping = new Mapping($this->definition(
            1000, 
            'route',
            1000,
            null,
            1002,
            1000
        ));

        $beeceptor_user_to_beeceptor_employee_mapping->save();
    }

    private function definition($id, $type, $input_model, $input_endpoint, $output_endpoint, $route_id)
    {
        $parameters = [
            'id' => $id,
            'type' => $type,
            'input_model' => $input_model,
            'input_endpoint' => $input_endpoint,
            'output_endpoint' => $output_endpoint,
            'route_id' => $route_id
        ];

        return $parameters;
    }
}

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
            2000, 
            2000,
            null,
            2002,
            2000
        ));

        $beeceptor_user_to_beeceptor_employee_mapping->save();
    }

    private function definition($id, $input_model, $input_endpoint, $output_endpoint, $processable_id)
    {
        $parameters = [
            'id' => $id,
            'input_model' => $input_model,
            'input_endpoint' => $input_endpoint,
            'output_endpoint' => $output_endpoint,
            'processable_id' => $processable_id
        ];

        return $parameters;
    }
}

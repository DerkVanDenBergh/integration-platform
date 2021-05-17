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
            1000,
            1002,
            1000
        ));

        $beeceptor_user_to_beeceptor_employee_mapping->save();

        \Illuminate\Support\Facades\DB::statement("ALTER SEQUENCE routes_id_seq RESTART 11000;");
    }

    private function definition($id, $input_endpoint, $output_endpoint, $route_id)
    {
        $parameters = [
            'id' => $id,
            'input_endpoint' => $input_endpoint,
            'output_endpoint' => $output_endpoint,
            'route_id' => $route_id
        ];

        return $parameters;
    }
}

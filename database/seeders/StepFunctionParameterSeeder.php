<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\StepFunctionParameter;

class StepFunctionParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $break_if_parameter_1 = new StepFunctionParameter($this->definition(
            1000, 
            'Value 1',
            'value_1',
            'text', 
            1000,
            false
        ));

        $break_if_parameter_1->save();

        $break_if_parameter_2 = new StepFunctionParameter($this->definition(
            1001, 
            'Value 2',
            'value_2',
            'text', 
            1000,
            true
        ));

        $break_if_parameter_2->save();

        $text_var_parameter_1 = new StepFunctionParameter($this->definition(
            1002, 
            'Text', 
            'text',
            'text', 
            1001,
            false
        ));

        $text_var_parameter_1->save();
    }

    private function definition($id, $name, $parameter_name, $data_type, $step_function_id, $is_nullable)
    {
        $parameters = [
            'id' => $id,
            'name' => $name,
            'parameter_name' => $parameter_name,
            'data_type' => $data_type,
            'step_function_id' => $step_function_id,
            'is_nullable' => $is_nullable
        ];

        return $parameters;
    }
}
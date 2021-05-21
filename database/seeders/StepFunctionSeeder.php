<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\StepFunction;

class StepFunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $break_if = new StepFunction($this->definition(
            1000, 
            'Cancel execution if', 
            'This function will stop execution if the condition is met.', 
            'break_if',
            false
        ));

        $break_if->save();

        $text_var = new StepFunction($this->definition(
            1001, 
            'Text variable', 
            'Create a new text variable.',
            'text_var',
            true
        ));

        $text_var->save();
    }

    private function definition($id, $name, $description, $function_name, $has_return_value)
    {
        $parameters = [
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'function_name' => $function_name,
            'has_return_value' => $has_return_value
        ];

        return $parameters;
    }
}

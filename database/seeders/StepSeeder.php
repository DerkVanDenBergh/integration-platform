<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Step;

class StepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $break_if_id_is_empty = new Step($this->definition(
            2000, 
            2000, 
            'Cancel if id is empty', 
            1000, 
            1
        ));

        $break_if_id_is_empty->save();

        $append_initials = new Step($this->definition(
            2001, 
            2000, 
            'name including intitials', 
            1001, 
            2
        ));

        $append_initials->save();
    }

    private function definition($id, $processable_id, $name, $step_function_id, $order)
    {
        $parameters = [
            'id' => $id,
            'processable_id' => $processable_id,
            'name' => $name,
            'step_function_id' => $step_function_id,
            'order' => $order
        ];

        return $parameters;
    }
}

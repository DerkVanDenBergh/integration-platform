<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\StepArgument;

class StepArgumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $break_if_id_is_empty_value_1 = new StepArgument($this->definition(
            1000, 
            '![id]', 
            1000, 
            1000
        ));

        $break_if_id_is_empty_value_1->save();

        $break_if_id_is_empty_value_2 = new StepArgument($this->definition(
            1001, 
            '', 
            1000, 
            1001
        ));

        $break_if_id_is_empty_value_2->save();

        $append_initials_value_1 = new StepArgument($this->definition(
            1002, 
            '![name.first_name] (D.P.)', 
            1001, 
            1002
        ));

        $append_initials_value_1->save();
    }

    private function definition($id, $value, $step_id, $parameter_id)
    {
        $parameters = [
            'id' => $id,
            'value' => $value,
            'step_id' => $step_id,
            'parameter_id' => $parameter_id,
        ];

        return $parameters;
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\MappingField;

class MappingFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name_mapping_1 = new MappingField($this->definition(
            2000, 
            2006,
            2002,
            'model',
            2000
        ));

        $name_mapping_1->save();

        $name_mapping_2 = new MappingField($this->definition(
            2001, 
            2007,
            2003,
            'model',
            2000
        ));

        $name_mapping_2->save();

        $id_mapping = new MappingField($this->definition(
            2002, 
            2004,
            2000,
            'model',
            2000
        ));

        $id_mapping->save();
    }

    private function definition($id, $output_field, $input_field, $input_field_type, $mapping_id)
    {
        $parameters = [
            'id' => $id,
            'output_field' => $output_field,
            'input_field' => $input_field,
            'input_field_type' => $input_field_type,
            'mapping_id' => $mapping_id
        ];

        return $parameters;
    }
}

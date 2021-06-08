<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\DataModelField;

class DataModelFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_field_id = new DataModelField($this->definition(
            2000,
            2000,
            null,
            'id',
            'attribute',
            'integer'
        ));
        
        $user_field_id->save();

        $user_field_name = new DataModelField($this->definition(
            2001,
            2000,
            null,
            'name',
            'set',
            null
        ));
        
        $user_field_name->save();

        $user_field_name_first = new DataModelField($this->definition(
            2002,
            2000,
            2001,
            'first_name',
            'attribute',
            'string'
        ));
        
        $user_field_name_first->save();

        $user_field_name_last = new DataModelField($this->definition(
            2003,
            2000,
            2001,
            'last_name',
            'attribute',
            'string'
        ));
        
        $user_field_name_last->save();

        $employee_field_id = new DataModelField($this->definition(
            2004,
            2001,
            null,
            'employee_id',
            'attribute',
            'integer'
        ));
        
        $employee_field_id->save();

        $employee_field_name = new DataModelField($this->definition(
            2005,
            2001,
            null,
            'employee_name',
            'set',
            null
        ));
        
        $employee_field_name->save();

        $employee_field_name_first = new DataModelField($this->definition(
            2006,
            2001,
            2005,
            'first',
            'attribute',
            'string'
        ));
        
        $employee_field_name_first->save();

        $employee_field_name_last = new DataModelField($this->definition(
            2007,
            2001,
            2005,
            'last',
            'attribute',
            'string'
        ));
        
        $employee_field_name_last->save();
    }

    private function definition($id, $model_id, $parent_id, $name, $node_type, $data_type)
    {
        $parameters = [
            'id' => $id,
            'model_id' => $model_id,
            'parent_id' => $parent_id,
            'name' => $name,
            'node_type' => $node_type,
            'data_type' => $data_type,
        ];

        return $parameters;
    }
}

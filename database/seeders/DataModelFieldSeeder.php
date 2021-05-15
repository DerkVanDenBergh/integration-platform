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
        $field_id = new DataModelField($this->definition(
            1000,
            1000,
            null,
            'id',
            'attribute',
            'integer'
        ));
        
        $field_id->save();

        $field_name = new DataModelField($this->definition(
            1001,
            1000,
            null,
            'name',
            'set',
            null
        ));
        
        $field_name->save();

        $field_name_first = new DataModelField($this->definition(
            1002,
            1000,
            1001,
            'first_name',
            'attribute',
            'string'
        ));
        
        $field_name_first->save();

        $field_name_last = new DataModelField($this->definition(
            1003,
            1000,
            1001,
            'last_name',
            'attribute',
            'string'
        ));
        
        $field_name_last->save();

        $field_age = new DataModelField($this->definition(
            1004,
            1000,
            null,
            'age',
            'attribute',
            'integer'
        ));
        
        $field_age->save();

        $field_role = new DataModelField($this->definition(
            1005,
            1000,
            null,
            'role',
            'attribute',
            'string'
        ));
        
        $field_role->save();
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

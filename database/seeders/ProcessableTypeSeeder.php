<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\ProcessableType;

class ProcessableTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $route = new ProcessableType($this->definition(
            1, 
            'route'
        ));

        $route->save();

        $task = new ProcessableType($this->definition(
            2, 
            'task'
        ));

        $task->save();
    }

    private function definition($id, $name)
    {
        $parameters = [
            'id' => $id,
            'name' => $name
        ];

        return $parameters;
    }
}

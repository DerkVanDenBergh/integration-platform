<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /* TODO: 
        * - Change seeding to factories
        * - Find a more elegant way of increasing auto increment in pgsql
        */

        // Essential seeds
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TemplateSeeder::class);
        $this->call(StepFunctionSeeder::class);
        $this->call(StepFunctionParameterSeeder::class);
        $this->call(ProcessableTypeSeeder::class);
        
        foreach(['role','user','data_model','data_model_field','connection','authentication','endpoint','processable','mapping','mapping_field','step', 'step_argument', 'step_function', 'step_function_parameter'] as $model) {
            $this->increaseSequence($model);
        }
        
    }

    public function increaseSequence($model)
    {
        $connection = config('database.default');

        $driver = config("database.connections.{$connection}.driver");

        if($driver == 'pgsql') {
            \Illuminate\Support\Facades\DB::statement("ALTER SEQUENCE {$model}s_id_seq RESTART 3000;");
        }

        
    }
}

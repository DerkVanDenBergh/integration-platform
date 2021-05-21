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
        $this->call(DataModelSeeder::class);
        $this->call(DataModelFieldSeeder::class);
        $this->call(TemplateSeeder::class);
        
        // Dummy data
        $this->call(ConnectionSeeder::class);
        $this->call(AuthenticationSeeder::class);
        $this->call(EndpointSeeder::class);
        $this->call(RouteSeeder::class);
        $this->call(MappingSeeder::class);
        $this->call(MappingFieldSeeder::class);
        $this->call(StepFunctionSeeder::class);
        $this->call(StepFunctionParameterSeeder::class);
        $this->call(StepSeeder::class);
        $this->call(StepArgumentSeeder::class);
        
        foreach(['role','user','data_model','data_model_field','connection','authentication','endpoint','route','mapping','mapping_field','step'] as $model) {
            $this->increaseSequence($model);
        }
        
    }

    public function increaseSequence($model)
    {
        $connection = config('database.default');

        $driver = config("database.connections.{$connection}.driver");

        if($driver == 'pgsql') {
            \Illuminate\Support\Facades\DB::statement("ALTER SEQUENCE {$model}s_id_seq RESTART 2000;");
        }

        
    }
}

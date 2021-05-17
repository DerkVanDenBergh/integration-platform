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
        
        
    }
}

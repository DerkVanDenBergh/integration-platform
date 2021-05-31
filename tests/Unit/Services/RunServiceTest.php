<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\RunService;
use App\Services\LogService;

use App\Models\Role;
use App\Models\Run;
use App\Models\Route;
use App\Models\User;

use PDOException; 

class RunServiceTest extends TestCase
{
    protected $runService;

    protected $faker;
    
    protected $route;
    protected $role;
    protected $user;

    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        $this->runService = new RunService(new LogService());

        // Set up faker
        $this->faker = \Faker\Factory::create();

        // Manually create related objects if needed
        $this->role = new Role([
            'title' => 'User', 
            'can_manage_users' => true,
            'can_manage_functions' => true,
            'can_manage_roles' => true,
            'can_manage_templates' => true
        ]);

        $this->role->save();

        $this->user = new User([
            'name' => $this->faker->name, 
            'email' => $this->faker->email,
            'password' => $this->faker->text,
            'role_id' => $this->role->id
        ]);

        $this->user->save();

        $this->route = new Route([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'active' => true,
            'slug' => $this->faker->text,
            'user_id' => $this->user->id
        ]);
        
        $this->route->save();
    }

    protected function tearDown(): void
    {
        $this->route->delete();
        $this->user->delete();
        $this->role->delete();
    }

    public function test_validRunDataShouldResultInStoredRun()
    {
        $run = $this->createTestEntity();

        $this->runService->delete($run);
    }

    public function test_badRunDataShouldNotResultInStoredRun()
    {
        $this->expectException(PDOException::class);
        
        $run = $this->createTestEntity(null, null, null, null);
    }

    public function test_validRunDataShouldResultInUpdatedRun()
    {
        $run = $this->createTestEntity();

        $run = $this->runService->update([
            'input' => 'test_update'
        ], $run);

        $this->assertTrue($run->input == 'test_update');

        $this->runService->delete($run);
    }

    public function test_badRunDataShouldNotResultInUpdatedRun()
    {
        $this->expectException(PDOException::class);

        $run = $this->createTestEntity();
        
        $run = $this->runService->update([
            'input' => null
        ], $run);
    }

    public function test_validRunIdShouldResultInDeletedRun()
    {
        $run = $this->createTestEntity();

        $id = $run->id;

        $this->runService->delete($run);

        $this->assertTrue($this->runService->findById($id) == null);
    }

    public function test_validIdShouldResultInFoundRun()
    {
        $run = $this->createTestEntity();

        $this->assertTrue($this->runService->findById($run->id)->name == $run->name);

        $this->runService->delete($run);
    }

    public function test_badIdShouldResultInNull()
    {
        $this->assertTrue($this->runService->findById(9999999999) == null);
    }

    public function test_callToFindAllShouldResultInMultipleRuns()
    {
        $runs = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->runService->findAll()->count() >= 4);

        foreach($runs as $run) {
            $this->runService->delete($run);
        }
    }

    public function test_callToFindAllFromRouteShouldResultInMultipleRuns()
    {
        $runs = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->runService->findAllFromRoute($this->route->id)->count() == 4);

        foreach($runs as $run) {
            $this->runService->delete($run);
        }
    }

    public function test_callToFindAllFromEmptyRouteShouldResultInNoRuns()
    {
        $runs = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->runService->findAllFromRoute($this->route->id + 1)->count() == 0);

        foreach($runs as $run) {
            $this->runService->delete($run);
        }
    }

    private function createTestEntity($process = 'generate', $type = 'generate', $status = 'generate', $input = 'generate', $output = 'generate')
    {
        // Fill arguments with random data if they are empty
        $process = ($process == 'generate') ? $this->route->id : $process;
        $type = ($type == 'generate') ? 'route' : $type;
        $status = ($status == 'generate') ? 'success' : $status;
        $input = ($input == 'generate') ? $this->faker->text : $input;
        $output = ($output == 'generate') ? $this->faker->text : $output;

        
        $run = $this->runService->store([
            'process_id' => $process,
            'type' => $type,
            'status' => $status,
            'input' => $input,
            'output' => $output
        ]);

        $this->assertTrue($run->process_id == $process);
        $this->assertTrue($run->type == $type);
        $this->assertTrue($run->status == $status);
        $this->assertTrue($run->input == $input);
        $this->assertTrue($run->output == $output);

        return $run;
    }
}

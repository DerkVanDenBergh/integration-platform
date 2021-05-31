<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\StepService;
use App\Services\LogService;
use App\Services\StepFunctionService;
use App\Services\StepArgumentService;

use App\Models\StepFunction;
use App\Models\Route;
use App\Models\Step;
use App\Models\User;
use App\Models\Role;

use PDOException; 

class StepServiceTest extends TestCase
{
    protected $stepService;

    protected $route;
    protected $stepFunction;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        
        $logService = new LogService();

        $this->stepService = new StepService(
            $logService,
            new StepFunctionService($logService),
            new StepArgumentService($logService)
        );

        // Set up faker
        $this->faker = \Faker\Factory::create();

        // Manually create related objects if needed
        $role = new Role([
            'title' => 'User', 
            'can_manage_users' => true,
            'can_manage_functions' => true,
            'can_manage_roles' => true,
            'can_manage_templates' => true
        ]);

        $role->save();

        $user = new User([
            'name' => $this->faker->name, 
            'email' => $this->faker->email,
            'password' => $this->faker->text,
            'role_id' => $role->id
        ]);

        $user->save();

        $this->route = new Route([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'active' => true,
            'slug' => $this->faker->text,
            'user_id' => $user->id
        ]);
        
        $this->route->save();

        $this->stepFunction = new StepFunction([
            'name' => $this->faker->text,
            'description' => $this->faker->text,
            'function_name' => $this->faker->text,
            'has_return_value' => true
        ]);
        $this->stepFunction->save();
    }

    public function test_validStepDataShouldResultInStoredStep()
    {
        $step = $this->createTestEntity();

        $this->stepService->delete($step);
    }

    public function test_badStepDataShouldNotResultInStoredStep()
    {
        $this->expectException(PDOException::class);
        
        $step = $this->createTestEntity(null, null, null, null);
    }

    public function test_validStepDataShouldResultInUpdatedStep()
    {
        $step = $this->createTestEntity();

        $step = $this->stepService->update([
            'name' => 'test_update'
        ], $step);

        $this->assertTrue($step->name == 'test_update');

        $this->stepService->delete($step);
    }

    public function test_badStepDataShouldNotResultInUpdatedStep()
    {
        $this->expectException(PDOException::class);

        $step = $this->createTestEntity();
        
        $step = $this->stepService->update([
            'name' => null
        ], $step);
    }

    public function test_validStepIdShouldResultInDeletedStep()
    {
        $step = $this->createTestEntity();

        $id = $step->id;

        $this->stepService->delete($step);

        $this->assertTrue($this->stepService->findById($id) == null);
    }

    public function test_validRouteIdShouldResultInDeletedStepsFromRoute()
    {
        $steps = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->stepService->findAllFromRoute($this->route->id)->count() == 5);

        $this->stepService->deleteAllFromRoute($this->route->id);

        $this->assertTrue($this->stepService->findAllFromRoute($this->route->id)->count() == 0);
    }

    public function test_validIdShouldResultInFoundStep()
    {
        $step = $this->createTestEntity();

        $this->assertTrue($this->stepService->findById($step->id)->name == $step->name);

        $this->stepService->delete($step);
    }

    public function test_badIdShouldResultInNull()
    {
        $this->assertTrue($this->stepService->findById(9999999999) == null);
    }

    public function test_callToFindAllShouldResultInMultipleSteps()
    {
        $steps = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->stepService->findAll()->count() >= 4);

        foreach($steps as $step) {
            $this->stepService->delete($step);
        }
    }

    public function test_callToFindAllStepsWithReturnValueFromRouteShouldResultInMultipleSteps()
    {
        $this->stepFunction->has_return_value = true;
        $this->stepFunction->save();
        
        $this->assertTrue($this->stepService->findAllStepsWithReturnValueFromRoute($this->route->id)->count() == 0);

        $this->stepFunction->has_return_value = false;
        $this->stepFunction->save();

        $this->assertTrue($this->stepService->findAllStepsWithReturnValueFromRoute($this->route->id)->count() == 0);

        $this->stepFunction->has_return_value = true;
        $this->stepFunction->save();
    }

    public function test_callToFindAllFromRouteShouldResultInMultipleSteps()
    {
        $steps = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->stepService->findAllFromRoute($this->route->id)->count() == 4);

        foreach($steps as $step) {
            $this->stepService->delete($step);
        }
    }

    public function test_callToFindAllFromEmptyRouteShouldResultInNoSteps()
    {
        $steps = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->stepService->findAllFromRoute($this->route->id + 1)->count() == 0);

        foreach($steps as $step) {
            $this->stepService->delete($step);
        }
    }

    private function createTestEntity($route = 'generate', $name = 'generate', $stepFunction = 'generate', $order = 'generate')
    {
        // Fill arguments with random data if they are empty
        $route = ($route == 'generate') ? $this->route->id : $route;
        $name = ($name == 'generate') ? $this->faker->text : $name;
        $stepFunction = ($stepFunction == 'generate') ? $this->stepFunction->id : $stepFunction;
        $order = ($order == 'generate') ? $this->faker->randomDigit : $order;

        
        $step = $this->stepService->store([
            'route_id' => $route,
            'name' => $name,
            'step_function_id' => $stepFunction,
            'order' => $order
        ]);

        $this->assertTrue($step->route_id == $route);
        $this->assertTrue($step->name == $name);
        $this->assertTrue($step->step_function_id == $stepFunction);
        $this->assertTrue($step->order == $order);

        return $step;
    }
}

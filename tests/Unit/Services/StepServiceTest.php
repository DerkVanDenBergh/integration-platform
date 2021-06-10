<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\StepService;
use App\Services\LogService;
use App\Services\StepFunctionService;
use App\Services\StepArgumentService;

use App\Models\StepFunction;
use App\Models\Processable;
use App\Models\Step;
use App\Models\User;
use App\Models\Role;

use PDOException; 

class StepServiceTest extends TestCase
{
    protected $stepService;

    protected $processable;
    protected $stepFunction;
    protected $role;
    protected $user;

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

        $this->processable = new Processable([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'type_id' => Processable::ROUTE,
            'active' => true,
            'slug' => $this->faker->text,
            'user_id' => $this->user->id
        ]);
        
        $this->processable->save();

        $this->stepFunction = new StepFunction([
            'name' => $this->faker->text,
            'description' => $this->faker->text,
            'function_name' => $this->faker->text,
            'has_return_value' => true
        ]);
        $this->stepFunction->save();
    }

    protected function tearDown(): void
    {
        $this->processable->delete();
        $this->stepFunction->delete();
        $this->role->delete();
        $this->user->delete;

        parent::tearDown();
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

    public function test_validProcessableIdShouldResultInDeletedStepsFromProcessable()
    {
        $steps = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->stepService->findAllFromProcessable($this->processable->id)->count() == 5);

        $this->stepService->deleteAllFromProcessable($this->processable->id);

        $this->assertTrue($this->stepService->findAllFromProcessable($this->processable->id)->count() == 0);
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

    public function test_callToFindAllStepsWithReturnValueFromProcessableShouldResultInMultipleSteps()
    {
        $this->stepFunction->has_return_value = true;
        $this->stepFunction->save();
        
        $this->assertTrue($this->stepService->findAllStepsWithReturnValueFromProcessable($this->processable->id)->count() == 0);

        $this->stepFunction->has_return_value = false;
        $this->stepFunction->save();

        $this->assertTrue($this->stepService->findAllStepsWithReturnValueFromProcessable($this->processable->id)->count() == 0);

        $this->stepFunction->has_return_value = true;
        $this->stepFunction->save();
    }

    public function test_callToFindAllFromProcessableShouldResultInMultipleSteps()
    {
        $steps = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->stepService->findAllFromProcessable($this->processable->id)->count() == 4);

        foreach($steps as $step) {
            $this->stepService->delete($step);
        }
    }

    public function test_callToFindAllFromEmptyProcessableShouldResultInNoSteps()
    {
        $steps = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->stepService->findAllFromProcessable($this->processable->id + 1)->count() == 0);

        foreach($steps as $step) {
            $this->stepService->delete($step);
        }
    }

    private function createTestEntity($processable = 'generate', $name = 'generate', $stepFunction = 'generate', $order = 'generate')
    {
        // Fill arguments with random data if they are empty
        $processable = ($processable == 'generate') ? $this->processable->id : $processable;
        $name = ($name == 'generate') ? $this->faker->text : $name;
        $stepFunction = ($stepFunction == 'generate') ? $this->stepFunction->id : $stepFunction;
        $order = ($order == 'generate') ? $this->faker->randomDigit : $order;

        
        $step = $this->stepService->store([
            'processable_id' => $processable,
            'name' => $name,
            'step_function_id' => $stepFunction,
            'order' => $order
        ]);

        $this->assertTrue($step->processable_id == $processable);
        $this->assertTrue($step->name == $name);
        $this->assertTrue($step->step_function_id == $stepFunction);
        $this->assertTrue($step->order == $order);

        return $step;
    }
}

<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\StepFunctionService;
use App\Services\LogService;

use App\Models\Role;
use App\Models\StepFunction;

use PDOException; 

class StepFunctionServiceTest extends TestCase
{
    protected $stepFunctionService;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        $this->stepFunctionService = new StepFunctionService(new LogService());

        // Set up faker
        $this->faker = \Faker\Factory::create();

        // Manually create related objects if needed
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_validStepFunctionDataShouldResultInStoredStepFunction()
    {
        $stepFunction = $this->createTestEntity();

        $this->stepFunctionService->delete($stepFunction);
    }

    public function test_badStepFunctionDataShouldNotResultInStoredStepFunction()
    {
        $this->expectException(PDOException::class);
        
        $stepFunction = $this->createTestEntity(null, null, null, null);
    }

    public function test_validStepFunctionDataShouldResultInUpdatedStepFunction()
    {
        $stepFunction = $this->createTestEntity();

        $stepFunction = $this->stepFunctionService->update([
            'name' => 'test_update'
        ], $stepFunction);

        $this->assertTrue($stepFunction->name == 'test_update');

        $this->stepFunctionService->delete($stepFunction);
    }

    public function test_badStepFunctionDataShouldNotResultInUpdatedStepFunction()
    {
        $this->expectException(PDOException::class);

        $stepFunction = $this->createTestEntity();
        
        $stepFunction = $this->stepFunctionService->update([
            'name' => null
        ], $stepFunction);
    }

    public function test_validStepFunctionIdShouldResultInDeletedStepFunction()
    {
        $stepFunction = $this->createTestEntity();

        $id = $stepFunction->id;

        $this->stepFunctionService->delete($stepFunction);

        $this->assertTrue($this->stepFunctionService->findById($id) == null);
    }

    public function test_validIdShouldResultInFoundStepFunction()
    {
        $stepFunction = $this->createTestEntity();

        $this->assertTrue($this->stepFunctionService->findById($stepFunction->id)->name == $stepFunction->name);

        $this->stepFunctionService->delete($stepFunction);
    }

    public function test_badIdShouldResultInNull()
    {
        $this->assertTrue($this->stepFunctionService->findById(9999999999) == null);
    }

    public function test_callToFindAllShouldResultInMultipleStepFunctions()
    {
        $stepFunctions = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->stepFunctionService->findAll()->count() >= 4);

        foreach($stepFunctions as $stepFunction) {
            $this->stepFunctionService->delete($stepFunction);
        }
    }

    private function createTestEntity($name = 'generate', $description = 'generate', $functionName = 'generate', $hasReturnValue = 'generate')
    {
        // Fill arguments with random data if they are empty
        $name = ($name == 'generate') ? $this->faker->text : $name;
        $description = ($description == 'generate') ? $this->faker->text : $description;
        $functionName = ($functionName == 'generate') ? $this->faker->text : $functionName;
        $hasReturnValue = ($hasReturnValue == 'generate') ? true : $hasReturnValue;

        
        $stepFunction = $this->stepFunctionService->store([
            'name' => $name,
            'description' => $description,
            'function_name' => $functionName,
            'has_return_value' => $hasReturnValue
        ]);

        $this->assertTrue($stepFunction->name == $name);
        $this->assertTrue($stepFunction->description == $description);
        $this->assertTrue($stepFunction->function_name == $functionName);
        $this->assertTrue($stepFunction->has_return_value == $hasReturnValue);

        return $stepFunction;
    }
}

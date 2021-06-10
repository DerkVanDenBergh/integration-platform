<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\ProcessableService;
use App\Services\MappingService;
use App\Services\MappingFieldService;
use App\Services\DataModelService;
use App\Services\DataModelFieldService;
use App\Services\RequestService;
use App\Services\EndpointService;
use App\Services\StepService;
use App\Services\StepFunctionService;
use App\Services\StepArgumentService;
use App\Services\LogService;
use App\Services\RunService;

use App\Models\Role;
use App\Models\User;
use App\Models\Processable;

use PDOException; 

class ProcessableServiceTest extends TestCase
{
    protected $processableService;

    protected $role;
    protected $user;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        $logService = new LogService();
        $mappingService = new MappingService($logService);
        $stepService = new StepService(
            $logService,
            new StepFunctionService($logService),
            new StepArgumentService($logService)
        );
        $modelService = new DataModelService($logService);

        $this->processableService = new ProcessableService(
            new RequestService(
                $mappingService, 
                $modelService,
                new MappingFieldService($logService), 
                new DataModelFieldService($logService), 
                new EndpointService($logService),
                $stepService
            ), 
            $mappingService, 
            $modelService,
            $logService,
            new RunService($logService),
            $stepService
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
    }

    protected function tearDown(): void
    {
        $this->role->delete();
        $this->user->delete();

        parent::tearDown();
    }

    public function test_validProcessableDataShouldResultInStoredProcessable()
    {
        $processable = $this->createTestEntity();

        $this->processableService->delete($processable);
    }

    public function test_badProcessableDataShouldNotResultInStoredProcessable()
    {
        $this->expectException(PDOException::class);
        
        $processable = $this->createTestEntity(null, null, null, null);
    }

    public function test_validProcessableDataShouldResultInUpdatedProcessable()
    {
        $processable = $this->createTestEntity();

        $processable = $this->processableService->update([
            'title' => 'test_update'
        ], $processable);

        $this->assertTrue($processable->title == 'test_update');

        $this->processableService->delete($processable);
    }

    public function test_badProcessableDataShouldNotResultInUpdatedProcessable()
    {
        $this->expectException(PDOException::class);

        $processable = $this->createTestEntity();
        
        $processable = $this->processableService->update([
            'title' => null
        ], $processable);
    }

    public function test_validProcessableIdShouldResultInDeletedProcessable()
    {
        $processable = $this->createTestEntity();

        $id = $processable->id;

        $this->processableService->delete($processable);

        $this->assertTrue($this->processableService->findById($id) == null);
    }

    public function test_validIdShouldResultInFoundProcessable()
    {
        $processable = $this->createTestEntity();

        $this->assertTrue($this->processableService->findById($processable->id)->title == $processable->title);

        $this->processableService->delete($processable);
    }

    public function test_badIdShouldResultInNull()
    {
        $this->assertTrue($this->processableService->findById(9999999999) == null);
    }

    public function test_validSlugShouldResultInFoundProcessable()
    {
        $processable = $this->createTestEntity();

        $this->assertTrue($this->processableService->findBySlug($processable->slug)->title == $processable->title);

        $this->processableService->delete($processable);
    }

    public function test_badslugShouldResultInNull()
    {
        $this->assertTrue($this->processableService->findBySlug('invalid_slug') == null);
    }

    public function test_validUserIdShouldResultInMultipleProcessables()
    {
        $processables = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->processableService->findAllFromUser($this->user->id)->count() >= 4);

        foreach($processables as $processable) {
            $this->processableService->delete($processable);
        }
    }

    public function test_validUserIdShouldResultInProcessablesFromSpecifiedUser()
    {
        $secondUser = new User([
            'name' => $this->faker->name, 
            'email' => $this->faker->email,
            'password' => $this->faker->text,
            'role_id' => $this->role->id
        ]);

        $secondUser->save();

        $processables = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(user: $secondUser->id)
        ];

        $this->assertTrue($this->processableService->findAllFromUser($this->user->id)->count() >= 3);
        $this->assertTrue($this->processableService->findAllFromUser($secondUser->id)->count() >= 1);

        foreach($processables as $processable) {
            $this->processableService->delete($processable);
        }

        $secondUser->delete();
    }

    public function test_callToFindAllShouldResultInMultipleProcessables()
    {
        $processables = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->processableService->findAll()->count() >= 4);

        foreach($processables as $processable) {
            $this->processableService->delete($processable);
        }
    }

    private function createTestEntity($title = 'generate', $type = 'generate', $description = 'generate', $active = 'generate', $slug = 'generate', $user = 'generate')
    {
        // Fill arguments with random data if they are empty
        $title = ($title == 'generate') ? $this->faker->text : $title;
        $type = ($type == 'generate') ? Processable::ROUTE : $type;
        $description = ($description == 'generate') ? $this->faker->text : $description;
        $active = ($active == 'generate') ? true : $active;
        $slug = ($slug == 'generate') ? $this->faker->text : $slug;
        $user = ($user == 'generate') ? $this->user->id : $user;

        
        $processable = $this->processableService->store([
            'title' => $title,
            'type_id' => $type,
            'description' => $description,
            'active' => $active,
            'user_id' => $user
        ]);

        $this->assertTrue($processable->title == $title);
        $this->assertTrue($processable->type_id == $type);
        $this->assertTrue($processable->description == $description);
        $this->assertTrue($processable->active == $active);
        $this->assertTrue($processable->user_id == $user);

        return $processable;
    }
}

<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\MappingService;
use App\Services\LogService;

use App\Models\Role;
use App\Models\User;
use App\Models\DataModel;
use App\Models\Processable;
use App\Models\Connection;
use App\Models\Endpoint;
use App\Models\Mapping;

use PDOException; 

class MappingServiceTest extends TestCase
{
    protected $mappingService;

    protected $processable;
    protected $inputModel;
    protected $outputEndpoint;
    protected $secondOutputEndpoint;
    protected $role;
    protected $connection;
    protected $user;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        $this->mappingService = new MappingService(new LogService());

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

        $this->inputModel = new DataModel([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'user_id' => $this->user->id,
            'template_id' => null
        ]);

        $this->inputModel->save();

        $this->connection = new Connection([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'base_url' => 'example.com/api',
            'user_id' => $this->user->id,
            'template' => false
        ]);

        $this->connection->save();

        $this->outputEndpoint = new Endpoint([
            'title' => $this->faker->text,
            'endpoint' => $this->faker->text,
            'protocol' => 'HTTP',
            'method' => 'POST',
            'connection_id' => $this->connection->id
        ]);

        $this->outputEndpoint->save();

        $this->secondOutputEndpoint = new Endpoint([
            'title' => $this->faker->text,
            'endpoint' => $this->faker->text,
            'protocol' => 'HTTP',
            'method' => 'POST',
            'connection_id' => $this->connection->id
        ]);

        $this->secondOutputEndpoint->save();
    }

    protected function tearDown(): void
    {
        $this->role->delete();
        $this->inputModel->delete();
        $this->outputEndpoint->delete();
        $this->secondOutputEndpoint->delete();
        $this->connection->delete();
        $this->role->delete();
        $this->user->delete();

        parent::tearDown();
    }

    public function test_validMappingDataShouldResultInStoredMapping()
    {
        $mapping = $this->createTestEntity();

        $this->mappingService->delete($mapping);
    }

    public function test_badMappingDataShouldNotResultInStoredMapping()
    {
        $this->expectException(PDOException::class);
        
        $mapping = $this->createTestEntity(null, null, null, null);
    }

    public function test_validMappingDataShouldResultInUpdatedMapping()
    {
        $mapping = $this->createTestEntity();

        $mapping = $this->mappingService->update([
            'output_endpoint' => $this->secondOutputEndpoint->id
        ], $mapping);

        $this->assertTrue($mapping->output_endpoint == $this->secondOutputEndpoint->id);

        $this->mappingService->delete($mapping);
    }

    public function test_badMappingDataShouldNotResultInUpdatedMapping()
    {
        $this->expectException(PDOException::class);

        $mapping = $this->createTestEntity();
        
        $mapping = $this->mappingService->update([
            'output_endpoint' => 'test'
        ], $mapping);
    }

    public function test_validMappingIdShouldResultInDeletedMapping()
    {
        $mapping = $this->createTestEntity();

        $id = $mapping->id;

        $this->mappingService->delete($mapping);

        $this->assertTrue($this->mappingService->findById($id) == null);
    }

    public function test_validIdShouldResultInFoundMapping()
    {
        $mapping = $this->createTestEntity();

        $this->assertTrue($this->mappingService->findById($mapping->id)->id == $mapping->id);

        $this->mappingService->delete($mapping);
    }

    public function test_badIdShouldResultInNull()
    {
        $this->assertTrue($this->mappingService->findById(9999999999) == null);
    }

    public function test_callToFindAllShouldResultInMultipleMappings()
    {
        $mappings = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->mappingService->findAll()->count() >= 4);

        foreach($mappings as $mapping) {
            $this->mappingService->delete($mapping);
        }
    }

    public function test_callToFindMappingFromProcessableWithValidProcessableIdShouldResultInSingleMapping()
    {
        $run = $this->createTestEntity();

        $this->assertTrue($this->mappingService->findByProcessableId($this->processable->id)->type == $run->type);

        $this->mappingService->delete($run);
    }

    public function test_callToFindMappingFromProcessableWithBadProcessableIdShouldResultInSingleMapping()
    {
        $this->assertTrue($this->mappingService->findByProcessableId(99999999) == null);
    }

    private function createTestEntity($inputModel = 'generate', $outputEndpoint = 'generate', $processable = 'generate')
    {
        // Fill arguments with random data if they are empty
        $inputModel = ($inputModel == 'generate') ? $this->inputModel->id : $inputModel;
        $outputEndpoint = ($outputEndpoint == 'generate') ? $this->outputEndpoint->id : $outputEndpoint;
        $processable = ($processable == 'generate') ? $this->processable->id : $processable;

        
        $mapping = $this->mappingService->store([
            'input_model' => $inputModel,
            'output_endpoint' => $outputEndpoint,
            'processable_id' => $processable
        ]);

        $this->assertTrue($mapping->input_model == $inputModel);
        $this->assertTrue($mapping->output_endpoint == $outputEndpoint);
        $this->assertTrue($mapping->processable_id == $processable);

        return $mapping;
    }
}

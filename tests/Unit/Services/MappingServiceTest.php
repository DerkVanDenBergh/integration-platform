<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\MappingService;
use App\Services\LogService;

use App\Models\Role;
use App\Models\User;
use App\Models\DataModel;
use App\Models\Route;
use App\Models\Connection;
use App\Models\Endpoint;
use App\Models\Mapping;

use PDOException; 

class MappingServiceTest extends TestCase
{
    protected $mappingService;

    protected $route;
    protected $inputModel;
    protected $outputEndpoint;

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

        $this->inputModel = new DataModel([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'user_id' => $user->id,
            'template_id' => null
        ]);

        $this->inputModel->save();

        $connection = new Connection([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'base_url' => 'example.com/api',
            'user_id' => $user->id,
            'template' => false
        ]);

        $connection->save();

        $this->outputEndpoint = new Endpoint([
            'title' => $this->faker->text,
            'endpoint' => $this->faker->text,
            'protocol' => 'HTTP',
            'method' => 'POST',
            'connection_id' => $connection->id
        ]);

        $this->outputEndpoint->save();


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
            'type' => 'test_update'
        ], $mapping);

        $this->assertTrue($mapping->type == 'test_update');

        $this->mappingService->delete($mapping);
    }

    public function test_badMappingDataShouldNotResultInUpdatedMapping()
    {
        $this->expectException(PDOException::class);

        $mapping = $this->createTestEntity();
        
        $mapping = $this->mappingService->update([
            'type' => null
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

        $this->assertTrue($this->mappingService->findById($mapping->id)->type == $mapping->type);

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

    public function test_callToFindMappingFromRouteWithValidRouteIdShouldResultInSingleMapping()
    {
        $run = $this->createTestEntity();

        $this->assertTrue($this->mappingService->findByRouteId($this->route->id)->type == $run->type);

        $this->mappingService->delete($run);
    }

    public function test_callToFindMappingFromRouteWithBadRouteIdShouldResultInSingleMapping()
    {
        $this->assertTrue($this->mappingService->findByRouteId(99999999) == null);
    }

    private function createTestEntity($inputModel = 'generate', $outputEndpoint = 'generate', $mappingType = 'generate', $route = 'generate')
    {
        // Fill arguments with random data if they are empty
        $inputModel = ($inputModel == 'generate') ? $this->inputModel->id : $inputModel;
        $outputEndpoint = ($outputEndpoint == 'generate') ? $this->outputEndpoint->id : $outputEndpoint;
        $mappingType = ($mappingType == 'generate') ? 'route' : $mappingType;
        $route = ($route == 'generate') ? $this->route->id : $route;

        
        $mapping = $this->mappingService->store([
            'input_model' => $inputModel,
            'output_endpoint' => $outputEndpoint,
            'type' => $mappingType,
            'route_id' => $route
        ]);

        $this->assertTrue($mapping->input_model == $inputModel);
        $this->assertTrue($mapping->output_endpoint == $outputEndpoint);
        $this->assertTrue($mapping->type == $mappingType);
        $this->assertTrue($mapping->route_id == $route);

        return $mapping;
    }
}

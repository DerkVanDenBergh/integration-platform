<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\HookService;
use App\Services\MappingService;
use App\Services\LogService;
use App\Services\RouteService;
use App\Services\DataModelService;
use App\Services\MappingFieldService;
use App\Services\DataModelFieldService;
use App\Services\EndpointService;
use App\Services\StepService;
use App\Services\StepFunctionService;
use App\Services\StepArgumentService;

use App\Models\Role;
use App\Models\User;
use App\Models\DataModel;
use App\Models\DataModelField;
use App\Models\Route;
use App\Models\Connection;
use App\Models\Endpoint;
use App\Models\Mapping;
use App\Models\MappingField;

use PDOException; 

class HookServiceTest extends TestCase
{
    protected $hookService;

    protected $role;
    protected $user;
    protected $route;
    protected $inputModel;
    protected $outputModel;
    protected $connection;
    protected $outputEndpoint;
    protected $mapping;
    protected $inputField;
    protected $outputField;
    protected $mappingField;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        $logService = new LogService();
        $this->hookService = new HookService(
            new RouteService(
                new MappingService($logService),
                $logService
            ),
            new MappingService($logService),
            new DataModelService($logService),
            new MappingFieldService($logService),
            new DataModelFieldService($logService),
            new EndpointService($logService),
            new StepService(
                $logService,
                new StepFunctionService($logService),
                new StepArgumentService($logService)
            )
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

        $this->route = new Route([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'active' => true,
            'slug' => $this->faker->text,
            'user_id' => $this->user->id
        ]);
        
        $this->route->save(); 

        $this->inputModel = new DataModel([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'user_id' => $this->user->id,
            'template_id' => null
        ]);

        $this->inputModel->save();

        $this->outputModel = new DataModel([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'user_id' => $this->user->id,
            'template_id' => null
        ]);

        $this->outputModel->save();

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
            'connection_id' => $this->connection->id,
            'model_id' => $this->outputModel->id
        ]);

        $this->outputEndpoint->save();
        
        $this->mapping = new Mapping([
            'input_model' => $this->inputModel->id,
            'output_endpoint' => $this->outputEndpoint->id,
            'type' => 'route',
            'route_id' => $this->route->id
        ]);

        $this->mapping->save();

        $this->inputField = new DataModelField([
            'model_id' => $this->inputModel->id,
            'name' => 'relevant_field',
            'node_type' => 'attribute',
            'data_type' => 'string'
        ]);

        $this->inputField->save();

        $this->outputField = new DataModelField([
            'model_id' => $this->outputModel->id,
            'name' => 'target_field',
            'node_type' => 'attribute',
            'data_type' => 'string'
        ]);

        $this->outputField->save();

        $this->mappingField = new MappingField([
            'mapping_id' => $this->mapping->id,
            'input_field' => $this->inputField->id,
            'input_field_type' => 'model',
            'output_field' => $this->outputField->id
        ]);

        $this->mappingField->save();
    }

    protected function tearDown(): void
    {
        $this->mapping->delete();
        $this->inputField->delete();
        $this->outputField->delete();
        $this->outputEndpoint->delete();
        $this->connection->delete();
        $this->outputModel->delete();
        $this->inputModel->delete();
        $this->route->delete();
        $this->user->delete();
        $this->role->delete();
        $this->mappingField->delete();

        parent::tearDown();

    }

    public function test_validateAuthenticationShouldReturnTrueWithValidAuthData()
    {
        // TODO
        $this->assertTrue(true);
    }

    public function test_validateAuthenticationShouldReturnFalseWithBadAuthData()
    {
        // TODO
        $this->assertFalse(false);
    }

    public function test_validateInputModelShouldReturnStrippedInputModel()
    {
        $data = [
            'relevant_field' => 'test',
            'unrelevant_field_1' => 'test',
            'unrelevant_field_2' => 'test'
        ];

        $processedModel = $this->hookService->validateInputModel($this->mapping, $data);

        $targetModel = [
            'relevant_field' => 'test'
        ];

        $this->assertTrue($processedModel == $targetModel);
    }

    public function test_populateModelFieldsShouldReturnPopulatedOutputModel()
    {
        $data = [
            'relevant_field' => 'test'
        ];

        $processedModel = $this->hookService->fillOutputModel($this->mapping, $data);

        $targetModel = [
            'target_field' => 'test'
        ];

        $this->assertTrue($processedModel == $targetModel);
    }
}

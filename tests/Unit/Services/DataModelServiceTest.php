<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\DataModelService;
use App\Services\LogService;

use App\Models\Role;
use App\Models\User;
use App\Models\DataModel;
use App\Models\Route;
use App\Models\Endpoint;
use App\Models\Mapping;
use App\Models\Connection;

use PDOException; 

class DataModelServiceTest extends TestCase
{
    protected $dataModelService;

    protected $role;
    protected $user;
    protected $route;
    protected $inputModel;
    protected $outputModel;
    protected $outputEndpoint;
    protected $mapping;
    protected $connection;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        $this->dataModelService = new DataModelService(new LogService());

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
    }

    protected function tearDown(): void
    {
        $this->role->delete();
        $this->user->delete();

        $this->role->delete();
        $this->user->delete();
        $this->route->delete();
        $this->inputModel->delete();
        $this->outputModel->delete();
        $this->outputEndpoint->delete();
        $this->mapping->delete();
        $this->connection->delete();

        parent::tearDown();
    }

    public function test_validDataModelDataShouldResultInStoredDataModel()
    {
        $dataModel = $this->createTestEntity();

        $this->dataModelService->delete($dataModel);
    }

    public function test_badDataModelDataShouldNotResultInStoredDataModel()
    {
        $this->expectException(PDOException::class);
        
        $dataModel = $this->createTestEntity(null, null, null, null);
    }

    public function test_validDataModelDataShouldResultInUpdatedDataModel()
    {
        $dataModel = $this->createTestEntity();

        $dataModel = $this->dataModelService->update([
            'title' => 'test_update'
        ], $dataModel);

        $this->assertTrue($dataModel->title == 'test_update');

        $this->dataModelService->delete($dataModel);
    }

    public function test_badDataModelDataShouldNotResultInUpdatedDataModel()
    {
        $this->expectException(PDOException::class);

        $dataModel = $this->createTestEntity();
        
        $dataModel = $this->dataModelService->update([
            'title' => null
        ], $dataModel);
    }

    public function test_validDataModelIdShouldResultInDeletedDataModel()
    {
        $dataModel = $this->createTestEntity();

        $id = $dataModel->id;

        $this->dataModelService->delete($dataModel);

        $this->assertTrue($this->dataModelService->findById($id) == null);
    }

    public function test_validIdShouldResultInFoundDataModel()
    {
        $dataModel = $this->createTestEntity();

        $this->assertTrue($this->dataModelService->findById($dataModel->id)->title == $dataModel->title);

        $this->dataModelService->delete($dataModel);
    }

    public function test_badIdShouldResultInNull()
    {
        $this->assertTrue($this->dataModelService->findById(9999999999) == null);
    }

    public function test_callToFindAllShouldResultInMultipleDataModels()
    {
        $dataModels = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->dataModelService->findAll()->count() >= 4);

        foreach($dataModels as $dataModel) {
            $this->dataModelService->delete($dataModel);
        }
    }

    public function test_callToFindAllFromUserShouldResultInMultipleModels()
    {
        $dataModels = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->dataModelService->findAllFromUser($this->user->id)->count() == 6); // 2 more because of the input and output model

        foreach($dataModels as $dataModel) {
            $this->dataModelService->delete($dataModel);
        }
    }

    public function test_callToFindAllFromEmptyUserShouldResultInNoModels()
    {
        $dataModels = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->dataModelService->findAllFromUser($this->user->id + 1)->count() == 0);

        foreach($dataModels as $dataModel) {
            $this->dataModelService->delete($dataModel);
        }
    }

    public function test_validMappingIdShouldResultInValidInputModel()
    {
        $this->assertTrue($this->dataModelService->findInputModelByMappingId($this->mapping->id)->title == $this->inputModel->title);
    }

    public function test_validMappingIdShouldResultInValidOutputModel()
    {
        $this->assertTrue($this->dataModelService->findOutputModelByMappingId($this->mapping->id)->title == $this->outputModel->title);
    }

    public function test_availableOptionsShouldHaveOptionAndLabelProperties()
    {
        $options = $this->dataModelService->getOptions();

        foreach($options as $option) {
            $this->assertTrue(isset($option->option));
            $this->assertTrue(isset($option->label));
        }
    }

    private function createTestEntity($title = 'generate', $description = 'generate', $user = 'generate')
    {
        // Fill arguments with random data if they are empty
        $title = ($title == 'generate') ? $this->faker->text : $title;
        $description = ($description == 'generate') ? $this->faker->text : $description;
        $user = ($user == 'generate') ? $this->user->id : $user;

        $dataModel = $this->dataModelService->store([
            'title' => $title,
            'description' => $description,
            'user_id' => $user
        ]);

        $this->assertTrue($dataModel->title == $title);
        $this->assertTrue($dataModel->description == $description);
        $this->assertTrue($dataModel->user_id == $user);

        return $dataModel;
    }
}

<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\MappingFieldService;
use App\Services\LogService;

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

class MappingFieldServiceTest extends TestCase
{
    protected $mappingFieldService;

    protected $mapping;
    protected $inputField;
    protected $outputField;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        $this->mappingFieldService = new MappingFieldService(new LogService());

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

        $route = new Route([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'active' => true,
            'slug' => $this->faker->text,
            'user_id' => $user->id
        ]);
        
        $route->save(); 

        $inputModel = new DataModel([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'user_id' => $user->id,
            'template_id' => null
        ]);

        $inputModel->save();

        $outputModel = new DataModel([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'user_id' => $user->id,
            'template_id' => null
        ]);

        $outputModel->save();

        $connection = new Connection([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'base_url' => 'example.com/api',
            'user_id' => $user->id,
            'template' => false
        ]);

        $connection->save();

        $outputEndpoint = new Endpoint([
            'title' => $this->faker->text,
            'endpoint' => $this->faker->text,
            'protocol' => 'HTTP',
            'method' => 'POST',
            'connection_id' => $connection->id,
            'model_id' => $outputModel->id
        ]);

        $outputEndpoint->save();
        
        $this->mapping = new Mapping([
            'input_model' => $inputModel->id,
            'output_endpoint' => $outputEndpoint->id,
            'type' => 'route',
            'route_id' => $route->id
        ]);

        $this->mapping->save();

        $this->inputField = new DataModelField([
            'model_id' => $inputModel->id,
            'name' => $this->faker->text,
            'node_type' => 'attribute',
            'data_type' => 'string'
        ]);

        $this->inputField->save();

        $this->outputField = new DataModelField([
            'model_id' => $inputModel->id,
            'name' => $this->faker->text,
            'node_type' => 'attribute',
            'data_type' => 'string'
        ]);

        $this->outputField->save();
        
    }

    public function test_validMappingFieldDataShouldResultInStoredMappingField()
    {
        $mappingField = $this->createTestEntity();

        $this->mappingFieldService->delete($mappingField);
    }

    public function test_badMappingFieldDataShouldNotResultInStoredMappingField()
    {
        $this->expectException(PDOException::class);
        
        $mappingField = $this->createTestEntity(null, null, null, null);
    }

    public function test_validMappingFieldDataShouldResultInUpdatedMappingField()
    {
        $mappingField = $this->createTestEntity();

        $mappingField = $this->mappingFieldService->update([
            'input_field_type' => 'test_update'
        ], $mappingField);

        $this->assertTrue($mappingField->input_field_type == 'test_update');

        $this->mappingFieldService->delete($mappingField);
    }

    public function test_badMappingFieldDataShouldNotResultInUpdatedMappingField()
    {
        $this->expectException(PDOException::class);

        $mappingField = $this->createTestEntity();
        
        $mappingField = $this->mappingFieldService->update([
            'input_field_type' => null
        ], $mappingField);
    }

    public function test_validMappingFieldIdShouldResultInDeletedMappingField()
    {
        $mappingField = $this->createTestEntity();

        $id = $mappingField->id;

        $this->mappingFieldService->delete($mappingField);

        $this->assertTrue($this->mappingFieldService->findById($id) == null);
    }

    public function test_validIdShouldResultInFoundMappingField()
    {
        $mappingField = $this->createTestEntity();

        $this->assertTrue($this->mappingFieldService->findById($mappingField->id)->input_field_type == $mappingField->input_field_type);

        $this->mappingFieldService->delete($mappingField);
    }

    public function test_badIdShouldResultInNull()
    {
        $this->assertTrue($this->mappingFieldService->findById(9999999999) == null);
    }

    public function test_callToFindAllShouldResultInMultipleMappingFields()
    {
        $mappingFields = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->mappingFieldService->findAll()->count() >= 4);

        foreach($mappingFields as $mappingField) {
            $this->mappingFieldService->delete($mappingField);
        }
    }

    public function test_validMappingIdShouldResultInDeletedFieldsFromMapping()
    {
        $mappingFields = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->mappingFieldService->findAllFromMapping($this->mapping->id)->count() == 5);

        $this->mappingFieldService->deleteAllFromMapping($this->mapping->id);

        $this->assertTrue($this->mappingFieldService->findAllFromMapping($this->mapping->id)->count() == 0);
    }

    public function test_callToFindAllFromMappingShouldResultInMultipleFields()
    {
        $mappingFields = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->mappingFieldService->findAllFromMapping($this->mapping->id)->count() == 4);

        foreach($mappingFields as $mappingField) {
            $this->mappingFieldService->delete($mappingField);
        }
    }

    public function test_callToFindAllFromEmptyMappingShouldResultInNoFields()
    {
        $mappingFields = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->mappingFieldService->findAllFromMapping($this->mapping->id + 1)->count() == 0);

        foreach($mappingFields as $mappingField) {
            $this->mappingFieldService->delete($mappingField);
        }
    }

    public function test_callTofindByMappingAndOutputFieldIdWithValidIdsShouldResultInField()
    {
        $mappingField = $this->createTestEntity();

        $this->assertTrue($this->mappingFieldService->findByMappingAndOutputFieldId($this->mapping->id, $this->outputField->id)->type == $mappingField->type);

        $this->mappingFieldService->delete($mappingField);
    }

    public function test_callTofindByMappingAndOutputFieldIdWithBadIdsShouldResultInNoSteps()
    {
        $this->assertTrue($this->mappingFieldService->findByMappingAndOutputFieldId($this->mapping->id + 1, $this->outputField->id) == null);
    }

    private function createTestEntity($mapping = 'generate', $inputField = 'generate', $inputFieldType = 'generate', $outputField = 'generate')
    {
        // Fill arguments with random data if they are empty
        $mapping = ($mapping == 'generate') ? $this->mapping->id : $mapping;
        $inputField = ($inputField == 'generate') ? $this->inputField->id : $inputField;
        $inputFieldType = ($inputFieldType == 'generate') ? 'model' : $inputFieldType;
        $outputField = ($outputField == 'generate') ? $this->outputField->id : $outputField;

        
        $mappingField = $this->mappingFieldService->store([
            'mapping_id' => $mapping,
            'input_field' => $inputField,
            'input_field_type' => $inputFieldType,
            'output_field' => $outputField
        ]);

        $this->assertTrue($mappingField->mapping_id == $mapping);
        $this->assertTrue($mappingField->input_field == $inputField);
        $this->assertTrue($mappingField->input_field_type == $inputFieldType);
        $this->assertTrue($mappingField->output_field == $outputField);

        return $mappingField;
    }
}

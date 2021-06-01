<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\DataModelFieldService;
use App\Services\LogService;

use App\Models\Role;
use App\Models\User;
use App\Models\DataModel;
use App\Models\DataModelField;

use PDOException; 

class DataModelFieldServiceTest extends TestCase
{
    protected $dataModelFieldService;

    protected $role;
    protected $user;
    protected $model;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        $this->dataModelFieldService = new DataModelFieldService(new LogService());

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

        $this->model = new DataModel([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'user_id' => $this->user->id,
            'template_id' => null
        ]);

        $this->model->save();
    }

    protected function tearDown(): void
    {
        $this->role->delete();
        $this->user->delete();
        $this->model->delete();

        parent::tearDown();
    }

    public function test_validDataModelFieldDataShouldResultInStoredDataModelField()
    {
        $dataModelField = $this->createTestEntity();

        $this->dataModelFieldService->delete($dataModelField);
    }

    public function test_badDataModelFieldDataShouldNotResultInStoredDataModelField()
    {
        $this->expectException(PDOException::class);
        
        $dataModelField = $this->createTestEntity(null, null, null, null);
    }

    public function test_validDataModelFieldDataShouldResultInUpdatedDataModelField()
    {
        $dataModelField = $this->createTestEntity();

        $dataModelField = $this->dataModelFieldService->update([
            'name' => 'test_update'
        ], $dataModelField);

        $this->assertTrue($dataModelField->name == 'test_update');

        $this->dataModelFieldService->delete($dataModelField);
    }

    public function test_badDataModelFieldDataShouldNotResultInUpdatedDataModelField()
    {
        $this->expectException(PDOException::class);

        $dataModelField = $this->createTestEntity();
        
        $dataModelField = $this->dataModelFieldService->update([
            'name' => null
        ], $dataModelField);
    }

    public function test_validDataModelFieldIdShouldResultInDeletedDataModelField()
    {
        $dataModelField = $this->createTestEntity();

        $id = $dataModelField->id;

        $this->dataModelFieldService->delete($dataModelField);

        $this->assertTrue($this->dataModelFieldService->findById($id) == null);
    }

    public function test_validIdShouldResultInFoundDataModelField()
    {
        $dataModelField = $this->createTestEntity();

        $this->assertTrue($this->dataModelFieldService->findById($dataModelField->id)->name == $dataModelField->name);

        $this->dataModelFieldService->delete($dataModelField);
    }

    public function test_badIdShouldResultInNull()
    {
        $this->assertTrue($this->dataModelFieldService->findById(9999999999) == null);
    }

    public function test_callToFindAllShouldResultInMultipleDataModelFields()
    {
        $dataModelFields = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->dataModelFieldService->findAll()->count() >= 4);

        foreach($dataModelFields as $dataModelField) {
            $this->dataModelFieldService->delete($dataModelField);
        }
    }

    public function test_callToFindAllFromModelShouldResultInMultipleModelFields()
    {
        $dataModelFields = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->dataModelFieldService->findAllFromModel($this->model->id)->count() == 4); 

        foreach($dataModelFields as $dataModelField) {
            $this->dataModelFieldService->delete($dataModelField);
        }
    }

    public function test_callToFindAllFromEmptyModelShouldResultInNoModelFields()
    {
        $dataModelFields = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->dataModelFieldService->findAllFromModel($this->model->id + 1)->count() == 0);

        foreach($dataModelFields as $dataModelField) {
            $this->dataModelFieldService->delete($dataModelField);
        }
    }

    public function test_callToFindAllParentsFromModelShouldResultInParentModelFields()
    {
        $dataModelFields = [
            $this->createTestEntity(nodeType:'set'),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        array_push($dataModelFields, $this->createTestEntity(parent:$dataModelFields[0]->id));

        $this->assertTrue($this->dataModelFieldService->findAllParentsFromModel($this->model->id)->count() == 1);

        foreach($dataModelFields as $dataModelField) {
            $this->dataModelFieldService->delete($dataModelField);
        }
    }

    public function test_callToFindAllFieldNamesFromModelShouldResultInMultipleModelFieldNames()
    {
        $dataModelFields = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->dataModelFieldService->findAllFieldNamesFromModel($this->model->id)->count() == 4);

        foreach($dataModelFields as $dataModelField) {
            $this->dataModelFieldService->delete($dataModelField);
        }
    }

    public function test_callToFindAllAttributesFromModelShouldResultInMultipleModelFields()
    {
        $dataModelFields = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(nodeType:'set')
        ];

        $this->assertTrue($this->dataModelFieldService->findAllAttributesFromModel($this->model->id)->count() == 4); 

        foreach($dataModelFields as $dataModelField) {
            $this->dataModelFieldService->delete($dataModelField);
        }
    }

    public function test_availableDataTypesShouldHaveOptionAndLabelProperties()
    {
        $options = $this->dataModelFieldService->getDataTypes();

        foreach($options as $option) {
            $this->assertTrue(isset($option->option));
            $this->assertTrue(isset($option->label));
        }
    }

    public function test_availableNodeTypesShouldHaveOptionAndLabelProperties()
    {
        $options = $this->dataModelFieldService->getNodeTypes();

        foreach($options as $option) {
            $this->assertTrue(isset($option->option));
            $this->assertTrue(isset($option->label));
        }
    }

    private function createTestEntity($model = 'generate', $parent = 'generate', $name = 'generate', $nodeType = 'generate', $dataType = 'generate')
    {
        // Fill arguments with random data if they are empty
        $model = ($model == 'generate') ? $this->model->id : $model;
        $parent = ($parent == 'generate') ? null : $parent;
        $name = ($name == 'generate') ? $this->faker->text : $name;
        $nodeType = ($nodeType == 'generate') ? 'attribute' : $nodeType;
        $dataType = ($dataType == 'generate') ? 'string' : $dataType;
        
        $dataModelField = $this->dataModelFieldService->store([
            'model_id' => $model,
            'parent_id' => $parent,
            'name' => $name,
            'node_type' => $nodeType,
            'data_type' => $dataType
        ]);

        $this->assertTrue($dataModelField->model_id == $model);
        $this->assertTrue($dataModelField->parent_id == $parent);
        $this->assertTrue($dataModelField->name == $name);
        $this->assertTrue($dataModelField->node_type == $nodeType);
        $this->assertTrue($dataModelField->data_type == $dataType);

        return $dataModelField;
    }
}

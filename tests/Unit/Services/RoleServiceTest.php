<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\RoleService;
use App\Services\LogService;

use App\Models\Role;

use PDOException; 

class RoleServiceTest extends TestCase
{
    protected $roleService;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        $this->roleService = new RoleService(new LogService());

        // Set up faker
        $this->faker = \Faker\Factory::create();

        // Manually create related objects if needed
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_validRoleDataShouldResultInStoredRole()
    {
        $role = $this->createTestEntity();

        $this->roleService->delete($role);
    }

    public function test_badRoleDataShouldNotResultInStoredRole()
    {
        $this->expectException(PDOException::class);
        
        $role = $this->createTestEntity(null, null, null, null);
    }

    public function test_validRoleDataShouldResultInUpdatedRole()
    {
        $role = $this->createTestEntity();

        $role = $this->roleService->update([
            'title' => 'test_update'
        ], $role);

        $this->assertTrue($role->title == 'test_update');

        $this->roleService->delete($role);
    }

    public function test_badRoleDataShouldNotResultInUpdatedRole()
    {
        $this->expectException(PDOException::class);

        $role = $this->createTestEntity();
        
        $role = $this->roleService->update([
            'title' => null
        ], $role);
    }

    public function test_validRoleIdShouldResultInDeletedRole()
    {
        $role = $this->createTestEntity();

        $id = $role->id;

        $this->roleService->delete($role);

        $this->assertTrue($this->roleService->findById($id) == null);
    }

    public function test_validIdShouldResultInFoundRole()
    {
        $role = $this->createTestEntity();

        $this->assertTrue($this->roleService->findById($role->id)->title == $role->title);

        $this->roleService->delete($role);
    }

    public function test_badIdShouldResultInNull()
    {
        $this->assertTrue($this->roleService->findById(9999999999) == null);
    }

    public function test_callToFindAllShouldResultInMultipleRoles()
    {
        $roles = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->roleService->findAll()->count() >= 4);

        foreach($roles as $role) {
            $this->roleService->delete($role);
        }
    }

    private function createTestEntity($title = 'generate', $can_manage_users = 'generate', $can_manage_functions = 'generate', $can_manage_roles = 'generate', $can_manage_templates = 'generate')
    {
        // Fill arguments with random data if they are empty
        $title = ($title == 'generate') ? $this->faker->text : $title;
        $can_manage_users = ($can_manage_users == 'generate') ? true : $can_manage_users;
        $can_manage_functions = ($can_manage_functions == 'generate') ? true : $can_manage_functions;
        $can_manage_roles = ($can_manage_roles == 'generate') ? true : $can_manage_roles;
        $can_manage_templates = ($can_manage_templates == 'generate') ? true : $can_manage_templates;

        
        $role = $this->roleService->store([
            'title' => $title, 
            'can_manage_users' => $can_manage_users,
            'can_manage_functions' => $can_manage_functions,
            'can_manage_roles' => $can_manage_roles,
            'can_manage_templates' => $can_manage_templates
        ]);

        $this->assertTrue($role->title == $title);
        $this->assertTrue($role->can_manage_users == $can_manage_users);
        $this->assertTrue($role->can_manage_functions == $can_manage_functions);
        $this->assertTrue($role->can_manage_roles == $can_manage_roles);
        $this->assertTrue($role->can_manage_templates == $can_manage_templates);

        return $role;
    }
}

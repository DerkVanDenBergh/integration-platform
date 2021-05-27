<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\UserService;
use App\Services\LogService;

use App\Models\Role;
use App\Models\User;

use PDOException; 

class UserServiceTest extends TestCase
{
    protected $userService;

    protected $role;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        $this->userService = new UserService(new LogService());

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
    }

    public function test_validUserDataShouldResultInStoredUser()
    {
        $user = $this->createTestEntity();

        $this->userService->delete($user);
    }

    public function test_badUserDataShouldNotResultInStoredUser()
    {
        $this->expectException(PDOException::class);
        
        $user = $this->createTestEntity(null, null, null, null);
    }

    public function test_validUserDataShouldResultInUpdatedUser()
    {
        $user = $this->createTestEntity();

        $user = $this->userService->update([
            'name' => 'test_update'
        ], $user);

        $this->assertTrue($user->name == 'test_update');

        $this->userService->delete($user);
    }

    public function test_badUserDataShouldNotResultInUpdatedUser()
    {
        //$this->expectException(PDOException::class);

        $user = $this->createTestEntity();
        
        $user = $this->userService->update([
            'name' => null
        ], $user);
    }

    public function test_validUserIdShouldResultInDeletedUser()
    {
        $user = $this->createTestEntity();

        $id = $user->id;

        $this->userService->delete($user);

        $this->assertTrue($this->userService->findById($id) == null);
    }

    public function test_validIdShouldResultInFoundUser()
    {
        $user = $this->createTestEntity();

        $this->assertTrue($this->userService->findById($user->id)->name == $user->name);

        $this->userService->delete($user);
    }

    public function test_badIdShouldResultInNull()
    {
        $this->assertTrue($this->userService->findById(9999999999) == null);
    }

    public function test_callToFindAllShouldResultInMultipleUsers()
    {
        $users = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->userService->findAll()->count() >= 4);

        foreach($users as $user) {
            $this->userService->delete($user);
        }
    }

    private function createTestEntity($name = 'generate', $email = 'generate', $password = 'generate', $role = 'generate')
    {
        // Fill arguments with random data if they are empty
        $name = ($name == 'generate') ? $this->faker->name : $name;
        $email = ($email == 'generate') ? $this->faker->email : $email;
        $password = ($password == 'generate') ? $this->faker->text : $password;
        $role = ($role == 'generate') ? $this->role->id : $role;

        
        $user = $this->userService->store([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role_id' => $role
        ]);

        $this->assertTrue($user->name == $name);
        $this->assertTrue($user->email == $email);
        $this->assertTrue($user->role_id == $role);

        return $user;
    }
}

<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\AuthenticationService;
use App\Services\LogService;

use App\Models\Role;
use App\Models\User;
use App\Models\Connection;
use App\Models\Authentication;

use PDOException; 

class AuthenticationServiceTest extends TestCase
{
    protected $authenticationService;

    protected $role;
    protected $user;
    protected $connection;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        $this->authenticationService = new AuthenticationService(new LogService());

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

        $this->connection = new Connection([
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'base_url' => 'example.com/api',
            'user_id' => $this->user->id,
            'template' => false
        ]);

        $this->connection->save();
    }

    protected function tearDown(): void
    {
        $this->role->delete();
        $this->user->delete();
        $this->connection->delete();

        parent::tearDown();
    }

    public function test_validAuthenticationDataShouldResultInStoredAuthentication()
    {
        $authentication = $this->createTestEntity();

        $this->authenticationService->delete($authentication);
    }

    public function test_badAuthenticationDataShouldNotResultInStoredAuthentication()
    {
        $this->expectException(PDOException::class);
        
        $authentication = $this->createTestEntity(null, null, null, null);
    }

    public function test_validAuthenticationDataShouldResultInUpdatedAuthentication()
    {
        $authentication = $this->createTestEntity();

        $authentication = $this->authenticationService->update([
            'title' => 'test_update'
        ], $authentication);

        $this->assertTrue($authentication->title == 'test_update');

        $this->authenticationService->delete($authentication);
    }

    public function test_badAuthenticationDataShouldNotResultInUpdatedAuthentication()
    {
        $this->expectException(PDOException::class);

        $authentication = $this->createTestEntity();
        
        $authentication = $this->authenticationService->update([
            'title' => null
        ], $authentication);
    }

    public function test_validAuthenticationIdShouldResultInDeletedAuthentication()
    {
        $authentication = $this->createTestEntity();

        $id = $authentication->id;

        $this->authenticationService->delete($authentication);

        $this->assertTrue($this->authenticationService->findById($id) == null);
    }

    public function test_validIdShouldResultInFoundAuthentication()
    {
        $authentication = $this->createTestEntity();

        $this->assertTrue($this->authenticationService->findById($authentication->id)->title == $authentication->title);

        $this->authenticationService->delete($authentication);
    }

    public function test_badIdShouldResultInNull()
    {
        $this->assertTrue($this->authenticationService->findById(9999999999) == null);
    }

    public function test_callToFindAllShouldResultInMultipleAuthentications()
    {
        $authentications = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->authenticationService->findAll()->count() >= 4);

        foreach($authentications as $authentication) {
            $this->authenticationService->delete($authentication);
        }
    }

    private function createTestEntity($title = 'generate', $type = 'generate', $username = 'generate', $password = 'generate', $connection = 'generate')
    {
        // Fill arguments with random data if they are empty
        $title = ($title == 'generate') ? $this->faker->text : $title;
        $type = ($type == 'generate') ? 'basic' : $type;
        $username = ($username == 'generate') ? $this->faker->text : $username;
        $password = ($password == 'generate') ? $this->faker->text : $password;
        $connection = ($connection == 'generate') ? $this->connection->id : $connection;

        
        $authentication = $this->authenticationService->store([
            'title' => $title,
            'type' => $type,
            'username' => $username,
            'password' => $password,
            'connection_id' => $connection,
        ]);

        $this->assertTrue($authentication->title == $title);
        $this->assertTrue($authentication->type == $type);
        $this->assertTrue($authentication->username == $username);
        $this->assertTrue($authentication->password == $password);
        $this->assertTrue($authentication->connection_id == $connection);

        return $authentication;
    }
}

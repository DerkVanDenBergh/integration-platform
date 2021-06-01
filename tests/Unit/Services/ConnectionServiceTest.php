<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\ConnectionService;
use App\Services\LogService;

use App\Models\Role;
use App\Models\User;
use App\Models\Connection;

use PDOException; 

class ConnectionServiceTest extends TestCase
{
    protected $connectionService;

    protected $role;
    protected $user;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        $this->connectionService = new ConnectionService(new LogService());

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
        $this->actingAs($this->user);
    }

    protected function tearDown(): void
    {
        $this->role->delete();

        parent::tearDown();
    }

    public function test_validConnectionDataShouldResultInStoredConnection()
    {
        $connection = $this->createTestEntity();

        $this->connectionService->delete($connection);
    }

    public function test_badConnectionDataShouldNotResultInStoredConnection()
    {
        $this->expectException(PDOException::class);
        
        $connection = $this->createTestEntity(null, null, null, null);
    }

    public function test_validConnectionDataShouldResultInUpdatedConnection()
    {
        $connection = $this->createTestEntity();

        $connection = $this->connectionService->update([
            'title' => 'test_update'
        ], $connection);

        $this->assertTrue($connection->title == 'test_update');

        $this->connectionService->delete($connection);
    }

    public function test_badConnectionDataShouldNotResultInUpdatedConnection()
    {
        $this->expectException(PDOException::class);

        $connection = $this->createTestEntity();
        
        $connection = $this->connectionService->update([
            'title' => null
        ], $connection);
    }

    public function test_validConnectionIdShouldResultInDeletedConnection()
    {
        $connection = $this->createTestEntity();

        $id = $connection->id;

        $this->connectionService->delete($connection);

        $this->assertTrue($this->connectionService->findById($id) == null);
    }

    public function test_validIdShouldResultInFoundConnection()
    {
        $connection = $this->createTestEntity();

        $this->assertTrue($this->connectionService->findById($connection->id)->title == $connection->title);

        $this->connectionService->delete($connection);
    }

    public function test_badIdShouldResultInNull()
    {
        $this->assertTrue($this->connectionService->findById(9999999999) == null);
    }

    public function test_callToFindAllShouldResultInMultipleConnections()
    {
        $connections = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->connectionService->findAll()->count() >= 4);

        foreach($connections as $connection) {
            $this->connectionService->delete($connection);
        }
    }

    public function test_callToFindAllTemplatesShouldResultInMultipleTemplates()
    {
        $connections = [
            $this->createTestEntity(template: true),
            $this->createTestEntity(template: true),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->connectionService->findAllTemplates()->count() >= 2);

        foreach($connections as $connection) {
            $this->connectionService->delete($connection);
        }
    }

    public function test_callToGetTemplateSelectionShouldResultInMultipleTemplates()
    {
        $connections = [
            $this->createTestEntity(template: true),
            $this->createTestEntity(template: true),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->connectionService->getTemplateSelection()->count() >= 2);

        foreach($connections as $connection) {
            $this->connectionService->delete($connection);
        }
    }

    public function test_callToFindAllFromUserShouldResultInMultipleConnections()
    {
        $connections = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->connectionService->findAllFromUser($this->user->id)->count() == 4); 

        foreach($connections as $connection) {
            $this->connectionService->delete($connection);
        }
    }

    public function test_callToFindAllFromEmptyUserShouldResultInNoConnections()
    {
        $connections = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->connectionService->findAllFromUser($this->user->id + 1)->count() == 0);

        foreach($connections as $connection) {
            $this->connectionService->delete($connection);
        }
    }

    public function test_availableOptionsShouldHaveOptionAndLabelProperties()
    {
        $options = $this->connectionService->getOptions();

        foreach($options as $option) {
            $this->assertTrue(isset($option->option));
            $this->assertTrue(isset($option->label));
        }
    }

    public function test_validEndpointUrlShouldResultInFormattedUrl()
    {
        $url = 'api.example.com';
        
        $this->assertTrue($this->connectionService->formatBaseUrl($url) == 'api.example.com');
    }

    public function test_invalidEndpointUrlShouldResultInFormattedUrl()
    {
        $url = 'https://api.example.com/';
        
        $this->assertTrue($this->connectionService->formatBaseUrl($url) == 'api.example.com');
    }

    private function createTestEntity($title = 'generate', $description = 'generate', $url = 'generate', $user = 'generate', $template = false)
    {
        // Fill arguments with random data if they are empty
        $title = ($title == 'generate') ? $this->faker->text : $title;
        $description = ($description == 'generate') ? $this->faker->text : $description;
        $url = ($url == 'generate') ? $this->faker->text : $url;
        $user = ($user == 'generate') ? $this->user->id : $user;
        
        $connection = $this->connectionService->store([
            'title' => $title,
            'description' => $description,
            'base_url' => $url,
            'user_id' => $user,
            'template' => $template
        ]);

        $this->assertTrue($connection->title == $title);
        $this->assertTrue($connection->description == $description);
        $this->assertTrue($connection->base_url == $url);
        $this->assertTrue($connection->user_id == $user);
        $this->assertTrue($connection->template == $template);

        return $connection;
    }
}

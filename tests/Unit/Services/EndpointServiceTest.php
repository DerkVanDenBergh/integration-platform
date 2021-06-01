<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\EndpointService;
use App\Services\LogService;

use App\Models\Role;
use App\Models\User;
use App\Models\Connection;
use App\Models\Endpoint;
use App\Models\DataModel;

use PDOException; 

class EndpointServiceTest extends TestCase
{
    protected $endpointService;

    protected $role;
    protected $user;
    protected $model;
    protected $connection;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        $this->endpointService = new EndpointService(new LogService());

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
        $this->connection->delete();
        $this->model->delete();

        parent::tearDown();
    }

    public function test_validEndpointDataShouldResultInStoredEndpoint()
    {
        $endpoint = $this->createTestEntity();

        $this->endpointService->delete($endpoint);
    }

    public function test_badEndpointDataShouldNotResultInStoredEndpoint()
    {
        $this->expectException(PDOException::class);
        
        $endpoint = $this->createTestEntity(null, null, null, null);
    }

    public function test_validEndpointDataShouldResultInUpdatedEndpoint()
    {
        $endpoint = $this->createTestEntity();

        $endpoint = $this->endpointService->update([
            'title' => 'test_update'
        ], $endpoint);

        $this->assertTrue($endpoint->title == 'test_update');

        $this->endpointService->delete($endpoint);
    }

    public function test_badEndpointDataShouldNotResultInUpdatedEndpoint()
    {
        $this->expectException(PDOException::class);

        $endpoint = $this->createTestEntity();
        
        $endpoint = $this->endpointService->update([
            'title' => null
        ], $endpoint);
    }

    public function test_validModelIdShouldResultInUpdatedEndpoint()
    {
        $endpoint = $this->createTestEntity();

        $endpoint = $this->endpointService->updateModel($this->model->id, $endpoint);

        $this->assertTrue($endpoint->model_id == $this->model->id);

        $this->endpointService->delete($endpoint);
    }

    public function test_badModelIdShouldNotResultInUpdatedEndpoint()
    {
        $this->expectException(PDOException::class);

        $endpoint = $this->createTestEntity();
        
        $endpoint = $this->endpointService->updateModel($this->model->id + 1, $endpoint);
    }

    public function test_validEndpointIdShouldResultInDeletedEndpoint()
    {
        $endpoint = $this->createTestEntity();

        $id = $endpoint->id;

        $this->endpointService->delete($endpoint);

        $this->assertTrue($this->endpointService->findById($id) == null);
    }

    public function test_validIdShouldResultInFoundEndpoint()
    {
        $endpoint = $this->createTestEntity();

        $this->assertTrue($this->endpointService->findById($endpoint->id)->title == $endpoint->title);

        $this->endpointService->delete($endpoint);
    }

    public function test_badIdShouldResultInNull()
    {
        $this->assertTrue($this->endpointService->findById(9999999999) == null);
    }

    public function test_callToFindAllShouldResultInMultipleEndpoints()
    {
        $endpoints = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->endpointService->findAll()->count() >= 4);

        foreach($endpoints as $endpoint) {
            $this->endpointService->delete($endpoint);
        }
    }

    public function test_callToFindAllFromConnectionShouldResultInMultipleEndpoints()
    {
        $endpoints = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->endpointService->findAllFromConnection($this->connection->id)->count() == 4);

        foreach($endpoints as $endpoint) {
            $this->endpointService->delete($endpoint);
        }
    }

    public function test_callToFindAllFromEmptyConnectionShouldResultInNoEndpoints()
    {
        $endpoints = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->endpointService->findAllFromConnection($this->connection->id + 1)->count() == 0);

        foreach($endpoints as $endpoint) {
            $this->endpointService->delete($endpoint);
        }
    }

    public function test_callToFindAllFromUserShouldResultInMultipleEndpoints()
    {
        $endpoints = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->endpointService->findAllFromUser($this->user->id)->count() == 4);

        foreach($endpoints as $endpoint) {
            $this->endpointService->delete($endpoint);
        }
    }

    public function test_callToFindAllFromEmptyUserShouldResultInNoEndpoints()
    {
        $endpoints = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->endpointService->findAllFromUser($this->user->id + 1)->count() == 0);

        foreach($endpoints as $endpoint) {
            $this->endpointService->delete($endpoint);
        }
    }

    public function test_validIdShouldResultInURLFromEndpoint()
    {
        $endpoint = $this->createTestEntity();

        $this->assertTrue($this->endpointService->getUrlById($endpoint->id) == $this->connection->base_url . $endpoint->endpoint);

        $this->endpointService->delete($endpoint);
    }

    public function test_badIdShouldResultInNullFromEndpoint()
    {
        $endpoint = $this->createTestEntity();

        $this->assertTrue($this->endpointService->getUrlById($endpoint->id + 1) == null);

        $this->endpointService->delete($endpoint);
    }

    public function test_availableProtocolsShouldHaveOptionAndLabelProperties()
    {
        $options = $this->endpointService->getProtocols();

        foreach($options as $option) {
            $this->assertTrue(isset($option->option));
            $this->assertTrue(isset($option->label));
        }
    }

    public function test_availableHttpMethodsShouldHaveOptionProperties()
    {
        $options = $this->endpointService->getMethods('http');

        foreach($options as $option) {
            $this->assertTrue(isset($option->option));
        }
    }

    public function test_availableTcpMethodsShouldHaveOptionProperties()
    {
        $options = $this->endpointService->getMethods('tcp');

        foreach($options as $option) {
            $this->assertTrue(isset($option->option));
        }
    }

    public function test_validEndpointUrlShouldResultInFormattedUrl()
    {
        $url = '/endpoint';
        
        $this->assertTrue($this->endpointService->formatEndpointUrl($url) == '/endpoint');
    }

    public function test_invalidEndpointUrlShouldResultInFormattedUrl()
    {
        $url = 'endpoint/';
        
        $this->assertTrue($this->endpointService->formatEndpointUrl($url) == '/endpoint');
    }

    private function createTestEntity($title = 'generate', $endpointExt = 'generate', $protocol = 'generate', $method = 'generate', $connection = 'generate')
    {
        // Fill arguments with random data if they are empty
        $title = ($title == 'generate') ? $this->faker->text : $title;
        $endpointExt = ($endpointExt == 'generate') ? '/' . $this->faker->text : $endpointExt;
        $protocol = ($protocol == 'generate') ? 'HTTP' : $protocol;
        $method = ($method == 'generate') ? 'POST' : $method;
        $connection = ($connection == 'generate') ? $this->connection->id : $connection;

        
        $endpoint = $this->endpointService->store([
            'title' => $title,
            'endpoint' => $endpointExt,
            'protocol' => $protocol,
            'method' => $method,
            'connection_id' => $connection
        ]);

        $this->assertTrue($endpoint->title == $title);
        $this->assertTrue($endpoint->endpoint == $endpointExt);
        $this->assertTrue($endpoint->protocol == $protocol);
        $this->assertTrue($endpoint->method == $method);
        $this->assertTrue($endpoint->connection_id == $connection);

        return $endpoint;
    }
}

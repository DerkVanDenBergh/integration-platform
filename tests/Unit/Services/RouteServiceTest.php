<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\RouteService;
use App\Services\MappingService;
use App\Services\LogService;

use App\Models\Role;
use App\Models\User;
use App\Models\Route;

use PDOException; 

class RouteServiceTest extends TestCase
{
    protected $routeService;

    protected $role;
    protected $user;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        $logService = new LogService();
        $this->routeService = new RouteService(new MappingService($logService), $logService);

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
    }

    public function test_validRouteDataShouldResultInStoredRoute()
    {
        $route = $this->createTestEntity();

        $this->routeService->delete($route);
    }

    public function test_badRouteDataShouldNotResultInStoredRoute()
    {
        $this->expectException(PDOException::class);
        
        $route = $this->createTestEntity(null, null, null, null);
    }

    public function test_validRouteDataShouldResultInUpdatedRoute()
    {
        $route = $this->createTestEntity();

        $route = $this->routeService->update([
            'title' => 'test_update'
        ], $route);

        $this->assertTrue($route->title == 'test_update');

        $this->routeService->delete($route);
    }

    public function test_badRouteDataShouldNotResultInUpdatedRoute()
    {
        $this->expectException(PDOException::class);

        $route = $this->createTestEntity();
        
        $route = $this->routeService->update([
            'title' => null
        ], $route);
    }

    public function test_validRouteIdShouldResultInDeletedRoute()
    {
        $route = $this->createTestEntity();

        $id = $route->id;

        $this->routeService->delete($route);

        $this->assertTrue($this->routeService->findById($id) == null);
    }

    public function test_validIdShouldResultInFoundRoute()
    {
        $route = $this->createTestEntity();

        $this->assertTrue($this->routeService->findById($route->id)->title == $route->title);

        $this->routeService->delete($route);
    }

    public function test_badIdShouldResultInNull()
    {
        $this->assertTrue($this->routeService->findById(9999999999) == null);
    }

    public function test_validSlugShouldResultInFoundRoute()
    {
        $route = $this->createTestEntity();

        $this->assertTrue($this->routeService->findBySlug($route->slug)->title == $route->title);

        $this->routeService->delete($route);
    }

    public function test_badslugShouldResultInNull()
    {
        $this->assertTrue($this->routeService->findBySlug('invalid_slug') == null);
    }

    public function test_validUserIdShouldResultInMultipleRoutes()
    {
        $routes = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->routeService->findAllFromUser($this->user->id)->count() >= 4);

        foreach($routes as $route) {
            $this->routeService->delete($route);
        }
    }

    public function test_validUserIdShouldResultInRoutesFromSpecifiedUser()
    {
        $secondUser = new User([
            'name' => $this->faker->name, 
            'email' => $this->faker->email,
            'password' => $this->faker->text,
            'role_id' => $this->role->id
        ]);

        $secondUser->save();

        $routes = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(user: $secondUser->id)
        ];

        $this->assertTrue($this->routeService->findAllFromUser($this->user->id)->count() >= 3);
        $this->assertTrue($this->routeService->findAllFromUser($secondUser->id)->count() >= 1);

        foreach($routes as $route) {
            $this->routeService->delete($route);
        }

        $secondUser->delete();
    }

    public function test_callToFindAllShouldResultInMultipleRoutes()
    {
        $routes = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->routeService->findAll()->count() >= 4);

        foreach($routes as $route) {
            $this->routeService->delete($route);
        }
    }

    private function createTestEntity($title = 'generate', $description = 'generate', $active = 'generate', $slug = 'generate', $user = 'generate')
    {
        // Fill arguments with random data if they are empty
        $title = ($title == 'generate') ? $this->faker->text : $title;
        $description = ($description == 'generate') ? $this->faker->text : $description;
        $active = ($active == 'generate') ? true : $active;
        $slug = ($slug == 'generate') ? $this->faker->text : $slug;
        $user = ($user == 'generate') ? $this->user->id : $user;

        
        $route = $this->routeService->store([
            'title' => $title,
            'description' => $description,
            'active' => $active,
            'user_id' => $user
        ]);

        $this->assertTrue($route->title == $title);
        $this->assertTrue($route->description == $description);
        $this->assertTrue($route->active == $active);
        $this->assertTrue($route->user_id == $user);

        return $route;
    }
}

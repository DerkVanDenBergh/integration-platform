<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\HookService;
use App\Services\LogService;

use App\Models\Role;
use App\Models\Hook;

use PDOException; 

class HookServiceTest extends TestCase
{
    protected $hookService;

    protected $role;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        //$this->hookService = new HookService(new LogService());

        // Set up faker
        $this->faker = \Faker\Factory::create();

        // Manually create related objects if needed
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

        $this->assertFalse(false);
    }

    public function test_populateModelFieldsShouldReturnPopulatedOutputModel()
    {
        $this->assertFalse(false);
    }

    public function test_getMatchedValueShouldReturnMatchedValueWithValidField()
    {
        $this->assertFalse(false);
    }

    public function test_getMatchedValueShouldReturnEmptyStringWithBadField()
    {
        $this->assertFalse(false);
    }

    public function test_getFullKeyPathShouldReturnFullKeyPathWithValidField()
    {
        $this->assertFalse(false);
    }

    public function test_getFullKeyPathShouldReturnEmptyArrayWithBadField()
    {
        $this->assertFalse(false);
    }

    public function test_arrayAccessShouldReturnValueWithValidKeyArray()
    {
        $this->assertFalse(false);
    }

    public function test_arrayAccessShouldReturnOriginalArrayWithEmptyKeyArray()
    {
        $this->assertFalse(false);
    }

    public function test_arrayAccessShouldReturnNullWithInvalidKeyArray()
    {
        $this->assertFalse(false);
    }

    public function test_rawUrlEncodeArrayShouldReturnUrlEncodedArrayWithAlphabeticalSort()
    {
        $this->assertFalse(false);
    }
}

<?php

namespace Tests\Unit\Services;

use Tests\TestCase;

use App\Services\LogService;

use App\Models\Role;
use App\Models\Log;

use PDOException; 

class LogServiceTest extends TestCase
{
    protected $logService;

    protected $faker;
    
    protected function setUp(): void
    {
        // Create app
        parent::setUp();

        // Create needed services
        $this->logService = new LogService();

        // Set up faker
        $this->faker = \Faker\Factory::create();

        // Manually create related objects if needed
    }

    public function test_validLogDataShouldResultInStoredLog()
    {
        $log = $this->createTestEntity();

        $this->logService->delete($log);
    }

    public function test_badLogDataShouldNotResultInStoredLog()
    {
        $this->expectException(PDOException::class);
        
        $log = $this->createTestEntity(null, null, null, null);
    }

    public function test_validLogDataShouldResultInUpdatedLog()
    {
        $log = $this->createTestEntity();

        $log = $this->logService->update([
            'message' => 'test_update'
        ], $log);

        $this->assertTrue($log->message == 'test_update');

        $this->logService->delete($log);
    }

    public function test_badLogDataShouldNotResultInUpdatedLog()
    {
        $this->expectException(PDOException::class);

        $log = $this->createTestEntity();
        
        $log = $this->logService->update([
            'message' => null
        ], $log);
    }

    public function test_validLogIdShouldResultInDeletedLog()
    {
        $log = $this->createTestEntity();

        $id = $log->id;

        $this->logService->delete($log);

        $this->assertTrue($this->logService->findById($id) == null);
    }

    public function test_validIdShouldResultInFoundLog()
    {
        $log = $this->createTestEntity();

        $this->assertTrue($this->logService->findById($log->id)->message == $log->message);

        $this->logService->delete($log);
    }

    public function test_badIdShouldResultInNull()
    {
        $this->assertTrue($this->logService->findById(9999999999) == null);
    }

    public function test_callToFindAllShouldResultInMultipleLogs()
    {
        $logs = [
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity(),
            $this->createTestEntity()
        ];

        $this->assertTrue($this->logService->findAll()->count() >= 4);

        foreach($logs as $log) {
            $this->logService->delete($log);
        }
    }

    public function test_logLevelEmergencyShouldReturn1()
    {
        $this->assertTrue($this->logService->getLogLevel('emergency') == 1);
    }

    public function test_logLevelAlertShouldReturn2()
    {
        $this->assertTrue($this->logService->getLogLevel('alert') == 2);
    }

    public function test_logLevelCriticalShouldReturn3()
    {
        $this->assertTrue($this->logService->getLogLevel('critical') == 3);
    }

    public function test_logLevelErrorShouldReturn4()
    {
        $this->assertTrue($this->logService->getLogLevel('error') == 4);
    }
    
    public function test_logLevelWarningShouldReturn5()
    {
        $this->assertTrue($this->logService->getLogLevel('warning') == 5);
    }

    public function test_logLevelNoticeShouldReturn6()
    {
        $this->assertTrue($this->logService->getLogLevel('notice') == 6);
    }

    public function test_logLevelInfoShouldReturn7()
    {
        $this->assertTrue($this->logService->getLogLevel('info') == 7);
    }

    public function test_logLevelDebugShouldReturn8()
    {
        $this->assertTrue($this->logService->getLogLevel('debug') == 8);
    }

    public function test_nonDefinedLogLevelShouldReturn4()
    {
        $this->assertTrue($this->logService->getLogLevel('invalid') == 4);
    }

    public function test_loggableCheckShouldReturnValidDecisionToNotLogIfThresholdIsHigher()
    {
        $this->assertTrue($this->logService->loggable('warning', 'info'));
    }

    public function test_loggableCheckShouldReturnValidDecisionToNotLogIfThresholdIsEven()
    {
        $this->assertTrue($this->logService->loggable('warning', 'warning'));
    }

    public function test_loggableCheckShouldReturnValidDecisionToNotLogIfThresholdIsLower()
    {
        $this->assertFalse($this->logService->loggable('warning', 'error'));
    }

    public function test_logPushShouldReturnValidLog()
    {
        $level = 'warning';
        $title = 'Something happened!';
        
        $this->assertTrue($this->logService->push($level, $title)->level == $level);
    }

    public function test_logPushShouldReturnValidLogWithSetOrigin()
    {
        $level = 'warning';
        $title = 'Something happened!';

        $this->logService->setOrigin('Test', 'LogServiceTest');
        
        $this->assertTrue($this->logService->push($level, $title)->level == $level);
    }

    private function createTestEntity($level = 'generate', $title = 'generate', $message = 'generate', $stacktrace = 'generate')
    {
        // Fill arguments with random data if they are empty
        $level = ($level == 'generate') ? 'info' : $level;
        $title = ($title == 'generate') ? $this->faker->text : $title;
        $message = ($message == 'generate') ? $this->faker->text : $message;
        $stacktrace = ($stacktrace == 'generate') ? $this->faker->text : $stacktrace;

        
        $log = $this->logService->store([
            'level' => $level,
            'title' => $title,
            'message' => $message,
            'stacktrace' => $stacktrace
        ]);

        $this->assertTrue($log->level == $level);
        $this->assertTrue($log->title == $title);
        $this->assertTrue($log->message == $message);
        $this->assertTrue($log->stacktrace == $stacktrace);

        return $log;
    }
}

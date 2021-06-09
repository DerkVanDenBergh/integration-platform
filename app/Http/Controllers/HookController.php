<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\ProcessableService;
use App\Services\LogService;
use App\Services\RunService;

use App\Exceptions\BreakOnStepFunctionException;
use App\Exceptions\StepFunctionNotFoundException;
use App\Exceptions\ProcessableNotActiveException;
use App\Exceptions\ProcessableNotAuthorizedException;
use App\Exceptions\RequestNotCompatibleWithProcessibleModelException;

use App\Jobs\LogProcessable;

class HookController extends Controller
{
    protected $processableService;
    protected $logService;
    protected $runService;

    public function __construct(
        ProcessableService $processableService,
        LogService $logService,
        RunService $runService
    ) {
        $this->processableService = $processableService;
        $this->logService = $logService;
        $this->runService = $runService;
    }

    public function get()
    {

    }

    public function post(Request $request, $slug)
    {
        $processable = $this->processableService->findBySlug($slug); 

        $request = $request->toArray();
        
        $response = $this->processableService->process($processable, $request);

        return $response;
    }

    public function put()
    {

    }

    public function patch()
    {

    }

    public function delete()
    {

    }
}
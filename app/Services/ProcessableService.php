<?php

namespace App\Services;

use App\Models\Processable;

use Illuminate\Support\Str;

use App\Services\RequestService;
use App\Services\MappingService;
use App\Services\DataModelService;
use App\Services\LogService;
use App\Services\RunService;
use App\Services\StepService;

use App\Jobs\LogProcessable;

use App\Exceptions\ProcessableNotActiveException;
use App\Exceptions\RequestNotCompatibleWithProcessibleModelException;
use App\Exceptions\ProcessableDoesNotExistException;
use App\Exceptions\ProcessableNotAuthorizedException;
use App\Exceptions\BreakOnStepFunctionException;
use App\Exceptions\Exception;


class ProcessableService
{
    protected $requestService;
    protected $mappingService;
    protected $modelService;
    protected $logService;
    protected $runService;
    protected $stepService;

    public function __construct(
        RequestService $requestService, 
        MappingService $mappingService,
        DataModelService $modelService,
        LogService $logService,
        RunService $runService, 
        StepService $stepService
    ) {
        $this->requestService = $requestService;
        $this->mappingService = $mappingService;
        $this->modelService = $modelService;
        $this->logService = $logService;
        $this->runService = $runService;
        $this->stepService = $stepService;
    }

    public function store(array $data)
    {
        $data['active'] = array_key_exists('active', $data);
        $data['slug'] = Str::random(25);
        
        $processable = Processable::create($data);
    
        $processable->save();

        $this->mappingService->store([
            'processable_id' => $processable->id
        ]);

        $this->logService->push('info','created processable with id ' . $processable->id . '.', json_encode($processable));

        return $processable;
    }

    public function update(array $data, Processable $processable)
    {
        $data['active'] = array_key_exists('active', $data);

        $processable->update($data);

        $processable->save();

        $this->logService->push('info','updated processable with id ' . $processable->id . '.', json_encode($processable));

        return $processable;
    }

    public function delete(Processable $processable)
    {
       $processable->delete();

       $this->logService->push('info','deleted processable with id ' . $processable->id . '.', json_encode($processable));

       return $processable;
    }

    public function findById($id)
    {
        $processable = Processable::find($id);

        if($processable) {
            $this->logService->push('info','requested processable with id ' . $processable->id . '.', json_encode($processable));
        } else {
            $this->logService->push('warning','requested processable with id ' . $id . ' but was not found.');
        }

        return $processable;
    }

    public function findBySlug($slug)
    {
        $processable = Processable::where('slug', $slug)->first();

        if($processable) {
            $this->logService->push('info','requested processable with slug ' . $slug . '.', json_encode($processable));
        } else {
            $this->logService->push('warning','requested processable with slug ' . $slug . ' but was not found.');
        }

        return $processable;
    }

    public function findAll()
    {
       $processables = Processable::all();

       $this->logService->push('info','requested all processables.', json_encode($processables));

       return $processables;
    }

    public function findAllFromUser($id)
    {
        $processables = Processable::where('user_id', $id)->get();

        $this->logService->push('info','requesteed all processables associated with user with id ' . $id . '.');

        return $processables;
    }

    public function findAllProcessablesFromUserByType($id, $type)
    {
        $processables = Processable::where('user_id', $id)->where('type_id', $type)->get();

        $this->logService->push('info','requesteed all processables associated with user with id ' . $id . '.');

        return $processables;
    }

    public function validateProcessable($processable) 
    {
        if(!$processable) {
            throw new ProcessableDoesNotExistException('processable does not exist.');
        }

        if(!$processable->active) {
            throw new ProcessableNotActiveException('processable is not active.');
        }
    }

    public function validateAuthentication($processable, $request)
    {
        $authenticated = $this->requestService->validateAuthentication($processable, $request); 

        if(!$authenticated) {
            throw new ProcessableNotAuthorizedException('invalid authentication.');
        }
    }

    public function validateData($processable, $request, $mapping)
    {
        $data = $this->requestService->validateInputModel($mapping, $request);

        if($data == []) {
            throw new RequestNotCompatibleWithProcessibleModelException('data not compatible with model.');
        }

        return $data;
    }

    public function generateRequest($processable, $request, $mapping)
    {
        if($processable->type_id == $processable::ROUTE) {
            $this->validateAuthentication($processable, $request);
        }

        $data = $this->stepService->processSteps($processable, $this->validateData($processable, $request, $mapping));

        $output_model = $this->requestService->fillOutputModel($mapping, $data);

        return $output_model;
    }

    public function process($processable, $request)
    {
        try {
            $this->validateProcessable($processable);

            $mapping = $this->mappingService->findByProcessableId($processable->id);

            $output_model = $this->generateRequest($processable, $request, $mapping);

            $response = $this->requestService->sendModelToEndpoint($output_model, $mapping);

            LogProcessable::dispatchAfterResponse($processable, 'processable', 'success', json_encode($request), strval($response->getBody()), $this->logService, $this->runService);
        } catch (ProcessableDoesNotExistException $e) {
            $response =  response()->json(['status' => 'processable does not exist'], 400);

        } catch (BreakOnStepFunctionException | ProcessableNotActiveException $e) {
            $response =  response()->json(['status' => 'aborted'], 200);

            LogProcessable::dispatchAfterResponse($processable, 'processable', 'aborted', json_encode($request), 'error: ' . $e->getMessage(), $this->logService, $this->runService);
        } catch (ProcessableNotAuthorizedException $e) {
            $response =  response()->json(['status' => $e->getMessage()], 403);

            LogProcessable::dispatchAfterResponse($processable, 'processable', 'failure', json_encode($request), 'error: ' . $e->getMessage(), $this->logService, $this->runService);
        } catch (StepFunctionNotFoundException | RequestNotCompatibleWithProcessibleModelException | Exception $e) {
            $response =  response()->json(['error' => $e->getMessage()], 400);

            LogProcessable::dispatchAfterResponse($processable, 'processable', 'failure', json_encode($request), 'error: ' . $e->getMessage(), $this->logService, $this->runService);
        } 

        return $response;
    }

    public function executeTask($processable)
    {
        $mapping = $this->mappingService->findByProcessableId($processable->id);

        $request = $this->requestService->retrieveModelFromEndpoint($mapping);

        $response = $this->process($processable, $request->json());

        return $response;
    }
}

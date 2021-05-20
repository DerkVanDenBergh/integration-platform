<?php

namespace App\Services;

use App\Models\DataModel;
use App\Models\StepFunction;

use App\Services\LogService;

class StepFunctionService
{
    protected $logService;

    public function __construct(
        LogService $logService
    ) {
        $this->logService = $logService;
    }
    
    public function store(array $data)
    {
        $stepFunction = StepFunction::create($data);

        $stepFunction->save();

        $this->logService->push('info','created step function with id ' . $stepFunction->id . '.', json_encode($stepFunction));

        return $stepFunction;
    }

    public function update(array $data, StepFunction $stepFunction)
    {
        $stepFunction->update($data);

        $this->logService->push('info','updated step function with id ' . $stepFunction->id . '.', json_encode($stepFunction));

        return $stepFunction;
    }

    public function delete(StepFunction $stepFunction)
    {
       $stepFunction->delete();

       $this->logService->push('info','deleted step function with id ' . $stepFunction->id . '.', json_encode($stepFunction));

       return $stepFunction;
    }

    public function findById($id)
    {
       $stepFunction = StepFunction::find($id);

       $this->logService->push('info','requested step function with id ' . $stepFunction->id . '.', json_encode($stepFunction));

       return $stepFunction;
    }

    public function findAll()
    {
       $stepFunctions = StepFunction::all();

       $this->logService->push('info','requested all step functions.');

       return $stepFunctions;
    }

    public function findAllWithParameters()
    {
       $stepFunctions = StepFunction::with('step_function_parameters')->get();

       $this->logService->push('info','requested all step functions with parameters.');

       return $stepFunctions;
    }
}

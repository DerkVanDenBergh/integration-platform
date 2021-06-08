<?php

namespace App\Services;

use App\Models\DataModel;
use App\Models\Step;

use App\Services\LogService;

class StepService
{
    protected $logService;
    protected $stepFunctionService;
    protected $stepArgumentService;

    public function __construct(
        LogService $logService,
        StepFunctionService $stepFunctionService,
        StepArgumentService $stepArgumentService
    ) {
        $this->logService = $logService;
        $this->stepFunctionService = $stepFunctionService;
        $this->stepArgumentService = $stepArgumentService;
    }
    
    public function store(array $data)
    {
        $step = Step::create($data);

        $step->save();

        $this->logService->push('info','created step with id ' . $step->id . '.', json_encode($step));

        return $step;
    }

    public function update(array $data, Step $step)
    {
        $step->update($data);

        $this->logService->push('info','updated step with id ' . $step->id . '.', json_encode($step));

        return $step;
    }

    public function delete(Step $step)
    {
       $step->delete();

       $this->logService->push('info','deleted step with id ' . $step->id . '.', json_encode($step));

       return $step;
    }

    public function deleteAllFromProcessable($id)
    {
        $steps = Step::where('processable_id', $id)->get();
        
        foreach($steps as $step) {
            $this->delete($step);
        }
    }

    public function findById($id)
    {
        $step = Step::find($id);

        if($step) {
            $this->logService->push('info','requested step with id ' . $step->id . '.', json_encode($step));
        } else {
            $this->logService->push('warning','requested step with id ' . $id . ' but was not found.');
        }

        return $step;
    }

    public function findAll()
    {
        $steps = Step::all();

        $this->logService->push('info','requested all steps.');

        return $steps;
    }

    public function findAllStepsWithReturnValueFromProcessable($id)
    {
        $steps = Step::with('step_function')
                        ->where('processable_id', $id)
                        ->whereHas('step_function', function($query) {
                            $query->where('has_return_value', '=', true);
                        })
                        ->orderBy('order')
                        ->get();

        return $steps;
    }   

    public function findAllFromProcessable($id)
    {

        $steps = Step::where('processable_id', $id)->get();

        $this->logService->push('info','requested all steps associated with processable with id ' . $id . '.');

        return $steps;
    }

    public function processSteps($processable, $data)
    {
        $steps = $this->findAllFromProcessable($processable->id);

        foreach($steps as $step) {
            $function = $this->stepFunctionService->findById($step->step_function_id);

            $arguments = $this->stepArgumentService->findAllFromStep($step->id);
                
            $data[$step->name] = $this->stepFunctionService->executeFunction($function, $arguments, $data);
        }
        
        return $data;
    }
}

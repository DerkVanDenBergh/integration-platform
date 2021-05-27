<?php

namespace App\Services;

use App\Models\DataModel;
use App\Models\StepFunction;

use App\Services\LogService;

use App\Logic\StepFunctions\Factory\StepFunctionFactory;

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

        if($stepFunction) {
            $this->logService->push('info','requested step function with id ' . $stepFunction->id . '.', json_encode($stepFunction));
        } else {
            $this->logService->push('warning','requested step function with id ' . $id . ' but was not found.');
        }

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

    // TODO get rid of $originalData
    public function parseArguments($arguments, $data, $originalData, $keys = [])
    {
        foreach($data as $key=>$value) {

            $currentKeys = $keys;

            if(is_array($value)) {
                array_push($currentKeys, $key);

                $this->parseArguments($arguments, $data[$key], $originalData, $currentKeys);
            } else {
                array_push($currentKeys, $key);

                foreach($arguments as $argument) {
                    if(strpos($argument->value, '![' . implode('.', $currentKeys) . ']') !== false) {
                        $argument->value = str_replace('![' . implode('.', $currentKeys) . ']', $this->array_access($originalData, $currentKeys), $argument->value);
                    }
                }
            }
        }

        return $arguments;
    }

    private function array_access(&$array, $keys) {

        if ($keys) {
            $key = array_shift($keys);
    
            $sub = self::array_access(
                $array[$key],
                $keys
            );
    
            return $sub;
        } else {
            return $array;
        }
    }

    public function executeFunction($stepFunction, $arguments, $data)
    {
        $function = StepFunctionFactory::create($stepFunction->function_name);

        $arguments = $this->parseArguments($arguments, $data, $data);

        return $function->execute($arguments, $data);
    }
}

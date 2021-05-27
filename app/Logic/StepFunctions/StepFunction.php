<?php

namespace App\Logic\StepFunction;

class StepFunction
{
    public function execute($arguments, $data)
    {
        // virtual
    }

    private function getArgument($arguments, $name)
    {
        // TODO this can be done faster, for example by swapping argument and parameter around
        foreach($arguments as $argument) {
            if($argument->step_function_parameter->parameter_name == $name) {
                return($argument->value);
            }
        }

        return null;
    }
}

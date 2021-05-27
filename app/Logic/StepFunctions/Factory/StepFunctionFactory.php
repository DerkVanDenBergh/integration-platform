<?php

namespace App\Logic\StepFunctions\Factory;

use App\Logic\TextVariableStepFunction;

class StepFunctionFactory
{

    public static function create($name, $arguments) 
    {      
        switch($name)
        {
            case 'text_var':
                return new TextVariableStepFunction();
                break;
        }
    }
}

<?php

namespace App\Logic\StepFunction\Factory;

use App\Logic\StepFunction\TextVariableStepFunction;
use App\Logic\StepFunction\BreakIfStepFunction;
use App\Logic\StepFunction\ParseJsonStepFunction;

class StepFunctionFactory
{

    public static function create($name) 
    {      
        switch($name)
        {
            case 'text_var':
                return new TextVariableStepFunction();
                break;

            case 'break_if':
                return new BreakIfStepFunction();
                break;

            case 'parse_json':
                return new ParseJsonStepFunction();
                break;
        }
    }
}

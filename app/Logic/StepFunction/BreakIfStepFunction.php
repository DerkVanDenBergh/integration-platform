<?php

namespace App\Logic\StepFunction;

use App\Exceptions\BreakOnStepFunctionException;

class BreakIfStepFunction extends StepFunction
{
    public function execute($arguments, $data)
    {
        $value_1 = parent::getArgument($arguments, 'value_1');
        $value_2 = parent::getArgument($arguments, 'value_2');

        if($value_1 === $value_2) {
            throw new BreakOnStepFunctionException('Step function called abort');
        } else {
            return true;
        }
    }
}

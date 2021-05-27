<?php

namespace App\Logic\StepFunction;

class TextVariableStepFunction extends StepFunction
{
    public function execute($arguments, $data)
    {
        $text = parent::getArgument($arguments, 'text');

        return $text;
    }
}

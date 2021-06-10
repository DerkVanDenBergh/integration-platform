<?php

namespace App\Logic\StepFunction;

class ParseJsonStepFunction extends StepFunction
{
    public function execute($arguments, $data)
    {
        $json = parent::getArgument($arguments, 'json');

        $var = json_decode($json, true);

        return $var;
    }
}

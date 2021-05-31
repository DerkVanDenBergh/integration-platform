<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\StepArgument;

class StepFunctionParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parameter_name',
        'data_type',
        'step_function_id',
        'is_nullable'
    ];

    public function getArgumentValueByStepAndParameterId($step_id, $parameter_id)
    {
        // TODO is a function call, make it a function call
        $argument = StepArgument::where('step_id', $step_id)->where('parameter_id', $parameter_id)->first();
        
        if($argument) {
            return $argument->value;
        } else {
            return null;
        }
    }
}

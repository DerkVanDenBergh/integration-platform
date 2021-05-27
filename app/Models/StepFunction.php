<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StepFunction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'function_name',
        'has_return_value'
    ];

    public function step_function_parameters () {
        return $this->hasMany( 'App\Models\StepFunctionParameter', 'step_function_id', 'id' );
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StepArgument extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'step_id',
        'parameter_id'
    ];

    public function parameter () {
        return $this->hasOne( 'App\Models\StepFunctionParameter', 'id', 'parameter_id' );
    }
}

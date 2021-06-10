<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    protected $fillable = [
        'processable_id',
        'name',
        'step_function_id',
        'order'
    ];

    public function step_function () {
        return $this->hasOne( 'App\Models\StepFunction', 'id', 'step_function_id' );
    }

    public function arguments () {
        return $this->hasMany( 'App\Models\StepArgument', 'step_id', 'id' );
    }

}

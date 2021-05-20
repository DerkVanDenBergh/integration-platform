<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'input_model',
        'input_endpoint',
        'output_endpoint',
        'route_id'
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function fields() {
        return $this->hasMany( 'App\Models\MappingField', 'mapping_id', 'id' );
    }
}

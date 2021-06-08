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
        'type',
        'processable_id'
    ];

    public function processable()
    {
        return $this->belongsTo(Processable::class);
    }

    public function fields() {
        return $this->hasMany( 'App\Models\MappingField', 'mapping_id', 'id' );
    }
}

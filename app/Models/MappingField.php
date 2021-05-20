<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappingField extends Model
{
    use HasFactory;

    protected $fillable = [
        'mapping_id',
        'input_field',
        'output_field'
    ];

    public function mapping(){
        return $this->hasOne( 'App\Models\Mapping', 'id', 'mapping_id' );
    }
}

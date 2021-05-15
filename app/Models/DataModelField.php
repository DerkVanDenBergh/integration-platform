<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataModelField extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'parent_id',
        'name',
        'node_type',
        'data_type'
    ];

    public function children(){
        return $this->hasMany( 'App\Models\DataModelField', 'parent_id', 'id' );
    }
      
    public function parent(){
        return $this->hasOne( 'App\Models\DataModelField', 'id', 'parent_id' );
    }
      
}

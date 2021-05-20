<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\MappingField;

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

    public function children() {
        return $this->hasMany( 'App\Models\DataModelField', 'parent_id', 'id' );
    }
      
    public function parent() {
        return $this->hasOne( 'App\Models\DataModelField', 'id', 'parent_id' );
    }

    // TODO make this nicer, can probably be done with helpers or embedding withing query
    public function getMappedInputField($mapping_id) {
        
        // is a service call, make it a service call
        $mappingField = MappingField::where('mapping_id', $mapping_id)->where('output_field', $this->id)->first();

        if($mappingField) {
            return $mappingField->input_field;
        } else {
            return null;
        }
    }
      
}

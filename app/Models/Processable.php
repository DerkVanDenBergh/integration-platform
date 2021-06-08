<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processable extends Model
{
    use HasFactory;

    const ROUTE = 1;
    const TASK = 2;

    protected $fillable = [
        'title',
        'type_id',
        'description',
        'active',
        'slug',
        'user_id'
    ];

    public function mapping() {
        return $this->hasOne( 'App\Models\Mapping', 'processable_id', 'id' );
    }
}

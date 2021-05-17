<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'active',
        'slug',
        'user_id'
    ];

    public function mapping() {
        return $this->hasOne( 'App\Models\Mapping', 'route_id', 'id' );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'endpoint',
        'protocol',
        'method',
        'port',
        'connection_id',
        'template'
    ];

    public function connection() {
        return $this->hasOne( 'App\Models\Connection', 'id', 'connection_id' );
    }

    public function authentication() {
        return $this->hasOne( 'App\Models\Authentication', 'id', 'authentication_id' );
    }
}

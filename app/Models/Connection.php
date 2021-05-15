<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'base_url',
        'user_id',
        'template'
    ];

    public function authentications()
    {
        return $this->hasMany( 'App\Models\Authentication', 'connection_id', 'id' )->get();
    }
      
    public function endpoints()
    {
        return $this->hasMany( 'App\Models\Endpoint', 'connection_id', 'id' )->get();
    }

}

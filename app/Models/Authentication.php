<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authentication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'username',
        'password',
        'key',
        'token',
        'connection_id',
        'template'
    ];
}

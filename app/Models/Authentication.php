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
        'token',
        'connection_id',
        'template',
        'oauth1_consumer_key',
        'oauth1_consumer_secret',
        'oauth1_token',
        'oauth1_token_secret'
    ];
}

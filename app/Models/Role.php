<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = array(
        'title', 
        'can_manage_users',
        'can_manage_functions',
        'can_manage_roles',
        'can_manage_templates'
    );
}

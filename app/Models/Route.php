<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Route extends Model
{
    use HasFactory, HasRoles;

    protected $guard_name = 'web';

    protected $fillable = ['name', 'uri', 'icon', 'order'];
}

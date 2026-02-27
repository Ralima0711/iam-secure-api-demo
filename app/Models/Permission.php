<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name'];

    /**
     * Uma permissão pode pertencer a vários roles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    /**
     * Um role pode pertencer a vários usuários
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Um role possui várias permissões
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
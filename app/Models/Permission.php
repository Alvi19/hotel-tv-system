<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['module', 'actions', 'description'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission')
            ->withPivot('actions')
            ->withTimestamps();
    }

    public function getActionArrayAttribute()
    {
        return explode(',', $this->actions ?? '');
    }
}

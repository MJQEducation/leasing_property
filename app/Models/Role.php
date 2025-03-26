<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name', 'is_admin', 'description', 'maker', 'delby',
    ];

    protected $dates = ['deleted_at'];

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', 'role_permission');
    }
}

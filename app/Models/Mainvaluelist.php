<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mainvaluelist extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'id',
        'abbreviation',
        'name_en',
        'name_kh',
        'type',
        'value',
        'code',
        'ordinal',
        'parent_mvl',
        'maker',
        'delby',
    ];
}

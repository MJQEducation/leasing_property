<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExitClearanceSignature extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'exit_id',
        'sign_title',
        'signed_id',
        'signed_code',
        'emp_name',
        'position',
        'is_signed',
        'ordinal',
        'signed_date',
        'delby',
        'maker',
    ];
}

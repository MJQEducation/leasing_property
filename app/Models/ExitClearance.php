<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExitClearance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'emp_id',
        'card_id',
        'name',
        'position',
        'department',
        'line_management',
        'email',
        'phone',
        'remarks',
        'hired_date',
        'last_working_date',
        'is_completed',
        'is_rejected',
        'rejected_id',
        'rejected_code',
        'rejected_name',
        'rejected_position',
        'delby',
        'maker',
        'status',
    ];
}

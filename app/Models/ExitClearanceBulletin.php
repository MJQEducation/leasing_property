<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExitClearanceBulletin extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'exit_id',
        'questionnaire',
        'checked_id',
        'checked_code',
        'emp_name',
        'position',
        'ordinal',
        'is_checked_completed',
        'is_completed',
        'completed_date',
        'maker',
        'delby',
    ];
}

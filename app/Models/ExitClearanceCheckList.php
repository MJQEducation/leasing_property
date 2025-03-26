<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExitClearanceCheckList extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bulletin_id',
        'questionnaire',
        'is_checked',
        'checked_id',
        'checked_code',
        'emp_name',
        'position',
        'is_checked',
        'checked_date',
        'ordinal',
        'remarks',
        'maker',
        'delby',
    ];
}

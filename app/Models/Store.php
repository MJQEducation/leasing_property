<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'store_code',
        'campus_id',
        'location_id',
        'status',
        'abbreviation_id',
        'name_kh',
        'name_en',
        'is_sub'

    ];
}

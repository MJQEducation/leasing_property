<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substore extends Model
{
    use HasFactory;

    protected $table = 'substore';

    protected $primaryKey = 'id';

    protected $fillable = [
        'substore_code',
        'store_code',
        'abbreviation_id',
        'name_kh',
        'name_en',
        'campus_id',
        'location_id',
        'status',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_code', 'store_code');
    }
}

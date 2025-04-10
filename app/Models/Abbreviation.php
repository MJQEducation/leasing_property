<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abbreviation extends Model
{
    use HasFactory;

    protected $table = 'abbreviations';

    protected $fillable = [
        'abbreviation',
        'status',
        'created_by',
    ];

    // Cast attributes to specific types
    protected $casts = [
        'status' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

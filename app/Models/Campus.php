<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;

    protected $table = 'campuses';

    // The attributes that are mass assignable
    protected $fillable = [
        'name_en', 'name_kh', 'created_by','status'
    ];

}

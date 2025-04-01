<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leasing extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural form of the model name
    protected $table = 'leasings';

    // Specify the primary key if it's not the default 'id'
    protected $primaryKey = 'id';

    // Specify which attributes should be mass assignable
    protected $fillable = [
        'contractid',
        'storeid',
        'owed_amount',
        'discount_request',
        'owner_offer',
        'final_charge',
        'alert_date',
    ];

    protected $dates = ['alert_date'];

    public $timestamps = true;
}

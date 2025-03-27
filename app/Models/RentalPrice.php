<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalPrice extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural of the model name
    protected $table = 'rental_price';

    // Specify the attributes that can be mass-assigned
    protected $fillable = [
        'price',
        'from',
        'to',
        'property_id',
        'user_id',
        'month_request',
        'month_offer',
        'descrease_amount',
        'amount_charge'
    ];

    // Define relationships if necessary (for example, if you have Property and User models)
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

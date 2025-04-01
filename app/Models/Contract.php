<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'contracts'; // Explicitly define table name

    protected $fillable = [
        'store_id',
        'customer_id',
        'deposit_amount',
        'management_fee',
        'water_fee',
        'penalty_payment',
        'start_date',
        'end_date',
        'remaining_days',
        'contract_type',
        'status',
        'monthly_fee',
        'year_fee',
        'contact_person',
    ];

    // Define relationships
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_code', 'store_code');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}

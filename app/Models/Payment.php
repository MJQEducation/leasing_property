<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'leasing_id',
        'payment_date',
        'penalty_amount',
        'final_charge',
        'amount_paid',
    ];

    protected $dates = ['payment_date'];

    public $timestamps = true;

    public function leasing()
    {
        return $this->belongsTo(Leasing::class, 'leasing_id');
    }
}

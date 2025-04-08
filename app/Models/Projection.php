<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projection extends Model
{
    use HasFactory;

    // Define the table name if it differs from the default
    protected $table = 'projections';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'contract_id',
        'projection_date',
        'estimated_income',
        'projected_by',
    ];

    // Define the relationships if needed
    public function contract()
    {
        return $this->belongsTo(User::class, 'contract_id');
    }

    public function projectedBy()
    {
        return $this->belongsTo(User::class, 'projected_by');
    }
}

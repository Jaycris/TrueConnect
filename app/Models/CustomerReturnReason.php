<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReturnReason extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'reason'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

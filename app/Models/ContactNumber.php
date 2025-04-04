<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'contact_number',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

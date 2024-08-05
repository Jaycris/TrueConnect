<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_created',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'address',
        'website',
        'lead_miner',
        'type',
        'deals',
        'notes',
        'verified_by',
        'comment',
        'assign_to'
    ];

    public function contactNumbers()
    {
        return $this->hasMany(ContactNumber::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'customer_employee', 'customer_id', 'employee_id');
    }

    public function fullName()
    {
        $middleInitial = $this->middle_name ? strtoupper($this->middle_name[0]) . '.' : '';
        return trim($this->first_name . ' ' . $middleInitial . ' ' . $this->last_name);
    }
}

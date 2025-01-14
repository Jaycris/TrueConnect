<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales';
    protected $fillable = [
        's_id',
        'date_sold',
        'consultant',
        'author_name',
        'gender',
        'book_title',
        'contact_number',
        'email',
        'mailing_address',
        'pack_type',
        'pack_sold',
        'total_price',
        'amount',
        'method',
    ];

    public function events()
    {
        return $this->hasMany(EndorsedEvents::class, 's_id', 's_id');
    }
}

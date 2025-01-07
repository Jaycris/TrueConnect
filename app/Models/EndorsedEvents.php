<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndorsedEvents extends Model
{
    use HasFactory;
    protected $table = 'endorsed_event';
    protected $fillable = [
        's_id',
        'event_name'
    ];

    public function sales()
    {
        return $this->belongsTo(Sale::class);
    }
}

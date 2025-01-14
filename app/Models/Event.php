<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'events';
    protected $fillable = [
        'event_name'
    ];

    public function packageSold()
    {
        return $this->belongsToMany(PackageSold::class, 'pack_sold_event', 'event_id', 'pack_sold_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageSold extends Model
{
    use HasFactory;
    protected $table = 'package_sold';
    protected $fillable = [
        'pack_sold_name',
        'price'
    ];

    public function packageType()
    {
        return $this->belongsToMany(PackageType::class, 'pack_type_pack_sold', 'pack_sold_id', 'pack_type_id');
    }

    public function event()
    {
        return $this->belongsToMany(Event::class, 'pack_sold_event', 'pack_sold_id', 'event_id');
    }
}

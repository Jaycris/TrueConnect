<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageType extends Model
{
    use HasFactory;
    protected $table = 'package_type';
    protected $fillable = [
        'pack_type_name'
    ];

    public function packageSold()
    {
        return $this->belongsToMany(PackageSold::class, 'pack_type_pack_sold', 'pack_type_id', 'pack_sold_id');
    }
}

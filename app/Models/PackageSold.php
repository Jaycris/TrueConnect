<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageSold extends Model
{
    use HasFactory;
    protected $table = 'package_sold';
    protected $fillable = [
        'pack_sold_name'
    ];
}

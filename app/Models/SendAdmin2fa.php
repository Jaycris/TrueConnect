<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendAdmin2fa extends Model
{
    use HasFactory;
    protected $table = 'send_admin_2fa';
    protected $fillable = ['key', 'value'];
}

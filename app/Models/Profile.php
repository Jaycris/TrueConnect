<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profile';
    protected $primaryKey = 'id'; // Default primary key is 'id'
    protected $fillable = [
        'user_id',
        'avatar',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'position',
        'department',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

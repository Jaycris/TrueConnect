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
        'e_id',
        'avatar',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'des_id',
        'department_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'des_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}

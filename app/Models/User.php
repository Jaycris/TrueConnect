<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use App\Notifications\VerifyDeviceEmail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use Notifiable;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'username',
        'password',
        'user_type',
        'user_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Generate a new 2FA secret for the user.
     */
    public function generateTwoFactorSecret(): string
    {
        $this->two_factor_secret = Str::random(32); // Generate a random secret
        $this->save();

        return $this->two_factor_secret;
    }

    /**
     * Generate and send 2FA code via email.
     */
    public function sendTwoFactorCode()
    {
        $code = rand(100000, 999999); // Generate a random 6-digit code
        $this->two_factor_code = $code;
        $this->two_factor_expires_at = now()->addMinutes(10); // Code expires in 10 minutes
        $this->save();

        $this->notify(new VerifyDeviceEmail($code));
    }

    /**
     * Check if the provided 2FA code is valid.
     */
    public function twoFactorCodeIsValid(string $code): bool
    {
        return !is_null($this->two_factor_code) &&
               $this->two_factor_code === $code &&
               now()->lt($this->two_factor_expires_at);
    }

    /**
     * Reset the 2FA code after successful verification.
     */
    public function resetTwoFactorCode()
    {
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    /**
     * Determine if the device is familiar.
     */
    public function isDeviceFamiliar(string $deviceIdentifier): bool
    {
        return in_array($deviceIdentifier, json_decode($this->familiar_devices, true) ?? []);
    }
    

    /**
     * Mark the device as familiar.
     */
    public function markDeviceAsFamiliar(string $deviceIdentifier)
    {
        $familiarDevices = json_decode($this->familiar_devices, true) ?? [];
        $familiarDevices[] = $deviceIdentifier;
        $this->familiar_devices = json_encode(array_unique($familiarDevices));
        $this->save();
    }

}

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

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_employee', 'employee_id', 'customer_id');
    }

    public function markTwoFactorVerified()
    {
        $this->two_factor_verified = true;
        $this->save();

        // \Log::info('Two-factor verified status updated:', ['user_id' => $this->id, 'status' => $this->two_factor_verified]);
    }

    /**
     * Generate and send 2FA code via email.
     */
    public function sendTwoFactorCode()
    {
        // \Log::info('Sending 2FA code'); // Debugging line
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
        $familiarDevices = json_decode($this->familiar_devices, true) ?? [];
        // \Log::info("Checking device: $deviceIdentifier");
        // \Log::info("Familiar devices: " . implode(', ', $familiarDevices));
        return in_array($deviceIdentifier, $familiarDevices);
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
        // \Log::info("Familiar devices updated: " . implode(', ', $familiarDevices));
    }

}

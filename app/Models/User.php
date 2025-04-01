<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
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
        'must_reset_password',
        'two_factor_enabled',
        'two_factor_recipient',
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
        return $this->hasOne(Profile::class, 'user_id');
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
        $currentTime = now();

        // Check if the last request was made within 60 seconds
        if ($this->two_factor_requested_at && $currentTime->diffInSeconds($this->two_factor_requested_at) < 60) {
            \Log::info('2FA resend blocked due to rate limit.');
            return false; // Prevent sending a new code
        }
        \Log::info('Sending 2FA code'); // Debugging line
        $code = rand(100000, 999999);
        $this->two_factor_code = $code;
        $this->two_factor_expires_at = now()->addMinutes(10); // Code expires in 10 minutes
        $this->two_factor_requested_at = now(); // Store when the code was requested
        $this->save();
        
        if ($this->two_factor_enabled) {
            if ($this->two_factor_recipient === 'Admin') {
                $adminEmail = SendAdmin2fa::where('key', 'admin_email')->value('value');
        
                if ($adminEmail) {
                    $profile = $this->profile; // Load the profile relationship
        
                    Notification::route('mail', $adminEmail)
                        ->notify(new VerifyDeviceEmail(
                            $code,
                            $profile ? $profile->fullName() : 'Admin Account',
                        ));
                    return;
                }
            }
        
            // Default: Send to user's email
            $profile = $this->profile; // Load the profile relationship
            $fullName = $profile ? $profile->fullName() : 'User Account';
        
            $this->notify(new VerifyDeviceEmail($code, $fullName, ''));
        }
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
        return in_array($deviceIdentifier, $familiarDevices, true);
    }
    

    /**
     * Mark the device as familiar.
     */
    public function markDeviceAsFamiliar(string $deviceIdentifier)
    {
        $familiarDevices = json_decode($this->familiar_devices, true) ?? [];
        if (!in_array($deviceIdentifier, $familiarDevices, true)) {
            $familiarDevices[] = $deviceIdentifier;
            $this->familiar_devices = json_encode($familiarDevices);
            $this->save();
        }
        // \Log::info("Familiar devices updated: " . implode(', ', $familiarDevices));
    }

}

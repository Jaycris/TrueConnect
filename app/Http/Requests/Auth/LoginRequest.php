<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Traits\DeviceIdentifier;
use App\Models\User;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
{
    use DeviceIdentifier; // Use the trait
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        $credentials = $this->only('password');

        // Attempt to authenticate with email or username
        $emailOrUsername = $this->input('email');
        if (filter_var($emailOrUsername, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $emailOrUsername;
        } else {
            $credentials['username'] = $emailOrUsername;
        }

        if (Auth::attempt($credentials, $this->boolean('remember'))) {
            $user = Auth::user();

            if (! $user->isDeviceFamiliar($this->deviceIdentifier())) {
                // Device is unfamiliar, send 2FA code via email
                $user->sendTwoFactorCode();

                // Redirect to verification page
                throw ValidationException::withMessages([
                    'email' => 'Please enter the 2FA code sent to your email.',
                ])->redirectTo(route('verify.2fa')); // Ensure redirect to 2FA page
            }

            RateLimiter::clear($this->throttleKey());
            return;
        }

        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }


    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }


    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')) . '|' . $this->ip();
    }

    /**
     * Get a unique identifier for the device.
     *
     * @return string
     */
    protected function deviceIdentifier()
    {
        return hash('sha256', request()->userAgent()); // Using a hashed user-agent as device identifier for better security
    }
}

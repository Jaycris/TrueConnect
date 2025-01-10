<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter; // Add this import
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use App\Traits\DeviceIdentifier;


class AuthenticatedSessionController extends Controller
{
    use DeviceIdentifier; // Use the trait

    /**
     * Display the login view.
     */
    public function create()
    { 
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        try {
            $user = $request->authenticate();
            $request->session()->regenerate();

            // Generate or get the device identifier
            $deviceIdentifier = $this->deviceIdentifier();
            Cookie::queue('device_identifier', $deviceIdentifier, 129600);

            // Log device identifier and existing identifier for debugging
            // \Log::info("Device identifier: $deviceIdentifier");
            // \Log::info("Existing identifier: $existingIdentifier");

            // Set or update the device identifier cookie
            // Cookie::queue('device_identifier', $deviceIdentifier, 60);

            // Check if the device is familiar
            if (! $user->isDeviceFamiliar($deviceIdentifier)) {
                // \Log::info("Device not familiar. Triggering 2FA.");
                $user->sendTwoFactorCode();

                // Use session flash data to store the 2FA redirection flag
                session()->flash('2fa_required', true);
                // Optional delay to address asynchronous issues
                sleep(1); // 1 second delay
                return redirect()->route('auth.2fa')->with('error', 'Please enter the 2FA code sent to your email.');
            }

            RateLimiter::clear($request->throttleKey());

            // Load the designation
            $user->load('profile.designation');

            // Store the user and their designation in the session
            session(['user' => $user]);

            if ($user->user_type == 'Admin') {
                return redirect()->intended('/admin')->with('success', 'Successfully Logged In');
            } elseif ($user->user_type == 'Employee') {
                return redirect()->intended('/employee')->with('success', 'Successfully Logged In');
            }

            return redirect()->intended('/')->with('success', 'Successfully Logged In');
        } catch (ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
            // return redirect()->route('auth.2fa')->with('error', 'Please enter the 2FA code sent to your email.');
        } catch (AuthenticationException $e) {
            // Handle authentication errors
            return redirect()->back()->with('error', 'Invalid credentials.');
        }
    }



    /**
     * Show the 2FA verification form.
     */
    public function showTwoFactorForm()
    {
        return view('auth.2fa');
    }

     /**
     * Verify the 2FA code entered by the user.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function verifyTwoFactor(Request $request)
    {
        // \Log::info('verifyTwoFactor method called'); // Debugging line

        $request->validate([
            'two_factor_code' => ['required', 'string'],
        ]);

        $user = Auth::user();

        if ($user->twoFactorCodeIsValid($request->input('two_factor_code'))) {
            $user->markTwoFactorVerified();
            $user->resetTwoFactorCode();

            // Mark current device as familiar
            $user->markDeviceAsFamiliar($this->deviceIdentifier());

            if ($user->must_reset_password) {
                return redirect()->route('password.reset.prompt');
            }

            // Redirect based on user type
            if ($user->user_type == 'Admin') {
                return redirect()->intended('/admin');
            } else if ($user->user_type == 'Employee') {
                return redirect()->intended('/employee');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors(['two_factor_code' => 'Invalid 2FA code.']);
    }

    public function showPasswordResetForm()
    {
        return view('auth.password_reset');
    }

    public function handlePasswordReset(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->must_reset_password = false; // Mark the password reset as complete
        $user->save();

        // Redirect based on user type
        if ($user->user_type == 'Admin') {
            return redirect()->intended('/admin')->with('success', 'Password updated successfully.');
        } elseif ($user->user_type == 'Employee') {
            return redirect()->intended('/employee')->with('success', 'Password updated successfully.');
        }

        return redirect()->intended('/')->with('success', 'Password updated successfully.');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Clear the device identifier cookie
        Cookie::queue(Cookie::forget('device_identifier'));
        // \Log::info('Device identifier cookie:', ['cookie' => Cookie::get('device_identifier')]);

        return redirect('/');
    }
}

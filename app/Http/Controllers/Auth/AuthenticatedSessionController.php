<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Traits\DeviceIdentifier;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;


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
            $request->authenticate();

            $request->session()->regenerate();

            $user = Auth::user();

            if (! $user->isDeviceFamiliar($this->deviceIdentifier())) {
                // Device is unfamiliar, redirect to 2FA verification
                return redirect()->route('auth.2fa');
            }

            // Redirect based on user type
            if ($user->user_type == 'Admin') {
                return redirect()->intended('/admin');
            } else if ($user->user_type == 'Employee') {
                return redirect()->intended('/employee');
            }

            return redirect()->intended('/');
        } catch (ValidationException $e) {
            // Handle 2FA verification redirect
            return redirect()->route('auth.2fa')->withErrors($e->errors());
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
        \Log::info('verifyTwoFactor method called'); // Debugging line

        $request->validate([
            'two_factor_code' => ['required', 'string'],
        ]);

        $user = Auth::user();

        if ($user->twoFactorCodeIsValid($request->input('two_factor_code'))) {
            $user->resetTwoFactorCode();

            // Mark current device as familiar
            $user->markDeviceAsFamiliar($this->deviceIdentifier());

            // Redirect based on user type
            if ($user->user_type == 'Admin') {
                \Log::info('Redirecting to admin dashboard'); // Debugging line
                return redirect()->intended('/admin');
            } else if ($user->user_type == 'Employee') {
                \Log::info('Redirecting to employee dashboard'); // Debugging line
                return redirect()->intended('/employee');
            }

            \Log::info('Redirecting to home'); // Debugging line
            return redirect()->intended('/');
        }

        \Log::error('Invalid 2FA code'); // Debugging line
        return back()->withErrors(['two_factor_code' => 'Invalid 2FA code.']);
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

        return redirect('/');
    }
}

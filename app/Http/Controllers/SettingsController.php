<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SendAdmin2fa;

class SettingsController extends Controller
{

    public function show()
    {
        $admins = User::where('user_type', 'Admin')->get();

        $selectedAdminEmail = SendAdmin2fa::where('key', 'admin_email')->value('value');
        return view('admin.2fa-recipient', compact('admins', 'selectedAdminEmail'));
    }

    public function updateAdmin(Request $request)
    {
        $validatedData = $request->validate(['admin_email' => 'required|email']);
        SendAdmin2fa::updateOrCreate(['key' => 'admin_email'], ['value' => $validatedData['admin_email']]);
        return redirect()->back()->with('success', 'Admin 2FA email updated successfully');
    }
}

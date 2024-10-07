<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Designation;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $users = User::with('profile')->get();
        return view('admin.users', compact('users'));
    }

    public function view($id)
    {
        $user   = User::with('profile')->find($id);
        return view('profile', compact('user'));
    }

    public function create()
    {
        $e_id = $this->generateUniqueEID();
        $departments = Department::get();
        $designations = Designation::get();

        return view('admin.users-create', compact('e_id','departments','designations'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'des_id' => 'required|string|max:255',
            'department_id' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|min:8|confirmed',
            'user_type' => 'required|string|max:255',
            'user_status' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'e_id' => 'required|string|max:255',
        ]);

        $user = new User([
            'email' => $validatedData['email'],
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
            'user_type' => $validatedData['user_type'],
            'user_status' => $validatedData['user_status'],
        ]);
        $user->save();
    
        $defaultAvatarPath = 'avatars/photo_defaults.png';
        $avatar = $defaultAvatarPath; // Default image if no avatar is uploaded

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $avatarName = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $avatar = $image->storeAs('avatars', $avatarName, 'public');
            // Optionally, you can log or perform other actions related to the upload
        }

    
        $profile = new Profile([
            'user_id' => $user->id,
            'e_id' => $validatedData['e_id'],
            'avatar' => $avatar,
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'],
            'last_name' => $validatedData['last_name'],
            'gender' => $validatedData['gender'],
            'des_id' => $validatedData['des_id'],
            'department_id' => $validatedData['department_id'],
        ]);
    
        $profile->save();
    
        return redirect()->route('admin.users')->with('success', 'User and Profile saved successfully');
    }

    public function generateUniqueEID()
    {
        $today = date('Ym');
        do{
            $e_id = $today . rand(100, 999);
        } while(Profile::where('e_id', $e_id)->exists());

        return $e_id;
    }

    public function edit($id)
    {
        $user = User::with(['profile.designation', 'profile.department'])->findOrFail($id);
        $genders = Profile::distinct()->pluck('gender')->toArray();
        $designations = Designation::all();
        $departments = Department::all();
        $types = User::distinct()->pluck('user_type')->toArray();
        $statuses = User::distinct()->pluck('user_status')->toArray();
        return view('admin.users-edit', compact('user', 'genders', 'designations', 'departments', 'types', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name'        => 'required|string|max:255',
            'middle_name'       => 'nullable|string|max:255',
            'last_name'         => 'required|string|max:255',
            'gender'            => 'required|string|max:255',
            'des_id'            => 'required|string|max:255',
            'department_id'     => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email,' . $id,
            'username'          => 'required|unique:users,username,' . $id,
            'user_type'         => 'required|string|max:255',
            'user_status'       => 'required||string|max:255',
            'avatar'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::findOrFail($id);
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->user_type = $request->input('user_type');
        $user->user_status = $request->input('user_status');
        $user->save();

        // Update the profile fields
        $profile = $user->profile;
        $profile->first_name = $request->input('first_name');
        $profile->middle_name = $request->input('middle_name');
        $profile->last_name = $request->input('last_name');
        $profile->gender = $request->input('gender');
        $profile->des_id = $request->input('des_id');
        $profile->department_id = $request->input('department_id');

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $avatarName = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $avatarPath = $image->storeAs('avatars', $avatarName, 'public');
            $profile->avatar = $avatarPath;
        }
        $profile->save();
        return redirect()->route('admin.users')->with('success', 'User updated');
    }

    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->profile) {
            $user->profile->delete();
        }
        $user->delete();

        return redirect('/admin/users')->with('success', 'User deleted!');
    }
}

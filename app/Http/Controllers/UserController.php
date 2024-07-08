<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('profile')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'        =>  'required|string|max:255',
            'middle_name'       =>  'nullable|string|max:255',
            'last_name'         =>  'required|string|max:255',
            'gender'            =>  'required|string|max:255',
            'position'          =>  'required|string|max:255',
            'department'        =>  'required|string|max:255',
            'email'             =>  'required|email|unique:users',
            'username'          =>  'required|string|unique:users',
            'password'          =>  'required|min:8',
            'user_type'         =>  'required|string|max:255',
            'user_status'       =>  'required|string|max:255',
        ]);

        $e_id = $this->generateUniqueEID();

        $user = new User([
            'e_id'          =>  $e_id,
            'email'         =>  $request->get('email'),
            'username'      =>  $request->get('username'),
            'password'      =>  Hash::make($request->get('password')),
            'user_type'     =>  $request->get('user_type'),
            'user_status'   =>  $request->get('user_status'),
        ]);

        $user->save();


        $profile = new Profile([
            'user_id'       =>  $user->id,
            'avatar'        =>  $request->get('avatar'),
            'first_name'    =>  $request->get('first_name'),
            'middle_name'   =>  $request->get('middle_name'),
            'last_name'     =>  $request->get('last_name'),
            'gender'        =>  $request->get('gender'),
            'position'      =>  $request->get('position'),
            'department'    =>  $request->get('department'),
        ]);

        $profile->save();

        return redirect('/users')->with('success', 'User created');
    }

    public function generateUniqueEID()
    {
        $today = date('Ym');
        do{
            $e_id = $today . rand(100, 999);
        } while(User::where('e_id', $e_id)->exists());

        return $e_id;
    }

    public function edit($id)
    {
        $user   = User::with('profile')->find($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name'        => 'required|string|max:255',
            'middle_name'       => 'requried|string|max:255',
            'last_name'         => 'required|string|max:255',
            'gender'            => 'required|string|max:255',
            'position'          => 'required|string|max:255',
            'department'        => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email,'.$id,
            'username'          => 'required|unique:users,username,'.$id,
            'password'          => 'nullable|min:8',
            'user_type'         => 'required|string|max:255',
            'user_status'       => 'required||string|max:255',
        ]);

        $user = User::find($id);
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->get('password'));
        }
        $user->user_type = $request->get('user_type');
        $user->user_status = $request->get('user_status');
        $user->save();

        $profile = $user->profile;
        $profile->avatar = $request->get('avatar');
        $profile->first_name = $request->get('first_name');
        $profile->middle_name = $request->get('middle_name');
        $profile->last_name = $request->get('last_name');
        $profile->gender  = $request->get('gender');
        $profile->position  = $request->get('position');
        $profile->department = $request->get('department');
        $profile->save();

        return redirect('/users')->with('success', 'User updated');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/users')->with('success', 'User deleted!');
    }
}

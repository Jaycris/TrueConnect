<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Profile;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::paginate(10);
        return view('admin.designations', compact('designations'));
    }

    public function create()
    {
        return view('admin.designations-create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $designations = new Designation([
            'name' => $validatedData['name'],
        ]);
        $designations->save();
    
        return redirect()->route('admin.designations')->with('success', 'User and Profile saved successfully');
    }

    public function edit($id)
    {
        $designations = Designation::find($id);

        return view('admin.designations-edit', compact('designations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
        ]);

        $designations = Designation::find($id);
        $designations->name = $request->input('name');
        $designations->save();

        return redirect()->route('admin.designation')->with('success', 'User updated');
    }

    public function destroy(Request $request, $id)
    {
        $designations = Designation::find($id);

        if (!$designations) {
            return redirect()->route('admin.designation')->with('error', 'Designation not found.');
        }

        $designations->delete();

        return redirect()->route('admin.designation')->with('success', 'Designation Deleted Successfully');
    }

    public function checkDesignation(Request $request, $id)
    {
        $designations = Designation::find($id);

        if (!$designations) {
            return response()->json([
                'status' => 'error',
                'message' => 'Designation not found.',
            ]);
        }

        $profiles = $designations->profiles;

        if ($profiles->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'There are users associated with this designation.',
                'profiles' => $profiles,
            ]);
        }

            return response()->json([
                'status' => 'success',
                'message' => 'Designation can be deleted.',
            ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Profile;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::paginate(10);
        return view('admin.departments', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments-create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $departments = new Department([
            'name' => $validatedData['name'],
        ]);
        $departments->save();
    
        return redirect()->route('admin.department')->with('success', 'User and Profile saved successfully');
    }

    public function edit($id)
    {
        $departments = Department::find($id);

        return view('admin.departments-edit', compact('departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
        ]);

        $departments = Department::find($id);
        $departments->name = $request->input('name');
        $departments->save();

        return redirect()->route('admin.department')->with('success', 'User updated');
    }

    public function destroy(Request $request, $id)
    {
        $departments = Department::find($id);

        if (!$departments) {
            return redirect()->route('admin.department')->with('error', 'Department not found.');
        }

        $departments->delete();

        return redirect()->route('admin.department')->with('success', 'Department Deleted Successfully');
    }

    public function checkDelete(Request $request, $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'status' => 'error',
                'message' => 'Department not found.',
            ]);
        }

        $profiles = $department->profiles;

        if ($profiles->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'There are users associated with this department.',
                'profiles' => $profiles,
            ]);
        }

            return response()->json([
                'status' => 'success',
                'message' => 'Department can be deleted.',
            ]);
    }

}

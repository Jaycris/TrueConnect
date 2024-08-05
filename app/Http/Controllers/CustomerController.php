<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ContactNumber;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('contactNumbers', 'books', 'employees')->get();
        $employees = User::where('user_type', 'Employee')->get();
        return view('customers.index', compact('customers', 'employees'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:customers,email',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'deals' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'assign_to' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            'contact_numbers' => 'required|array',
            'contact_numbers.*' => 'required|string|max:255',
            'books' => 'nullable|array',
            'books.*.title' => 'required|string|max:255',
            'books.*.link' => 'nullable|url|max:255'
        ]);

        $today = Carbon::now()->toDateString();

        $user = Auth::user();

        $customers = Customer::create([
            'date_created' => $today,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'address' => $request->address,
            'website' => $request->website,
            'lead_miner' => $user->profile->fullName(),
            'type' => $request->type,
            'deals' => $request->deals,
            'notes' => $request->notes,
            'verified_by' => $request->verified_by,
            'assign_to' => $request->assign_to,
            'comment' => $request->comment,
        ]);

        foreach ($request->contact_numbers as $contact_number) {
            $customer->contactNumbers()->create(['contact_number' => $contact_number, 'status' => 'Not Verified']);
        }

        if ($request->books) {
            foreach ($request->books as $book) {
                $customer->books()->create(['title' => $book['title'], 'link' => $book['link']]);
            }
        }

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function verifyContactNumber(ContactNumber $contactNumber)
    {
        $contactNumber->update(['status' => 'Verified']);

        return redirect()->route('customers.index')->with('success', 'Contact number verified successfully.');
    }

    public function showAssignForm(Customer $customer)
    {
        $employees = User::where('user_type', 'Employee')->get();
        return view('customers.assign', compact('customer', 'employees'));
    }

    public function assignEmployees(Request $request, Customer $customer)
    {
        $request->validate([
            'employees' => 'nullable|array',
            'employees.*' => 'exists:users,id',
        ]);

        $customer->employees()->sync($request->employees);
        $customer->update(['status' => 'Assigned']);

        return redirect()->route('customers.index')->with('success', 'Customer assigned successfully.');
    }

    public function returnToLeadMiner(Request $request, Customer $customer)
    {
        $request->validate([
            'correction_reason' => 'required|string|max:255',
        ]);

        $customer->update(['status' => 'Needs Correction', 'correction_reason' => $request->correction_reason]);

        return redirect()->route('customers.index')->with('success', 'Customer returned to lead miner for correction.');
    }

    public function reassignToEmployee(Request $request, Customer $customer)
    {
        $request->validate([
            'employees' => 'nullable|array',
            'employees.*' => 'exists:users,id',
        ]);

        $customer->employees()->sync($request->employees);
        $customer->update(['status' => 'Reassigned']);

        return redirect()->route('customers.index')->with('success', 'Customer reassigned successfully.');
    }
}

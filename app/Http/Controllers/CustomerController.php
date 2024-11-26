<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ContactNumber;
use App\Models\CustomerReturnReason;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with(['contactNumbers', 'books']) // Eager load relationships
                            ->whereHas('contactNumbers', function($query) {
                        $query->where('status', 'Not Verified');
                        })->get();        

        
        return view('customers.index', compact('customers'));
    }

    public function distroLeads()
    {
        $assignedCustomers = Customer::with(['contactNumbers', 'books'])
                                    ->whereNotNull('assign_to')
                                    ->get();

                                    // Query to get verified customers
        $unassignedLeads = Customer::with(['contactNumbers', 'books'])
                                    ->whereHas('contactNumbers', function ($query) {
                                $query->whereIn('status', ['Verified', 'DNC', 'VM']);
                                })
                                    ->whereDoesntHave('contactNumbers', function ($query) {
                                $query->whereNotIn('status', ['Verified', 'DNC', 'VM']);
                                })
                                ->whereNull('assign_to')  // Only include customers who are not assigned
                                ->get();

        $brandingSpecialists = User::whereHas('profile', function ($query) {
                                $query->where('des_id', function ($subQuery) {
                                $subQuery->select('id')->from('designations')->where('name', 'Branding Specialist');
                                });
                                })->get();
    
                                    
    
        $selectedCustomer = null;
        $employees = User::where('user_type', 'Employee')->get();                        


        return view('customers.distro', compact('assignedCustomers', 'unassignedLeads', 'selectedCustomer', 'employees', 'unassignedLeads', 'brandingSpecialists'));
    }

    public function returnedLeads()
    {
        $returnCustomers = Customer::with(['contactNumbers', 'books'])
                                ->whereNotNull('assign_to')  // Only include customers who are assigned
                                ->where('return_lead', true)
                                ->get();
        return view('customers.returned', compact('returnCustomers'));
    }

    public function userCustomer()
    {
        $userId = Auth::user()->id;

        // \Log::info('Logged-in User ID:', ['id' => $userId]);        
        $assignedCustomers = Customer::with(['contactNumbers', 'books'])
        ->where('assign_to', $userId)  // Ensure $userId is an integer
        ->where('return_lead', false)
        ->get();

        // \Log::info('Assigned Customers:', $assignedCustomers->toArray());        
        return view('employee.mycustomer', compact('assignedCustomers'));
    }

    public function show($id)
    {
        $customer = Customer::with('contactNumbers', 'books')->findOrFail($id);
        $currentUserName = Auth::user()->profile->fullName();

        // Retrieve the assigned employee's name based on the 'assign_to' user_id
        $assignedEmployeeName = null;
        if ($customer->assign_to) {
            $assignedEmployee = User::find($customer->assign_to);
            $assignedEmployeeName = $assignedEmployee ? $assignedEmployee->profile->fullName() : null;
        }

        return response()->json([
            'success' => true,
            'customer' => [
                'id' => $customer->id, // Ensure 'id' is included
                'name' => $customer->fullName(),
                'email' => $customer->email,
                'address' => $customer->address,
                'website' => $customer->website,
                'contact_numbers' => $customer->contactNumbers->map(function($contact) {
                    return [
                        'contact_number' => $contact->contact_number,
                        'status' => $contact->status,
                    ];
                }),
                'books' => $customer->books->map(function($book) {
                    return [
                        'title' => $book->title,
                        'link' => $book->link,
                    ];
                }),
                'assign_to' => $assignedEmployeeName,
                'is_viewed' => $customer->is_viewed,
                'current_user_name' => $currentUserName,
            ],
        ]);

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
            'contact_numbers' => 'required|array',
            'contact_numbers.*' => 'nullable|string|max:255',
            'books' => 'nullable|array',
            'books.*.title' => 'required|string|max:255',
            'books.*.link' => 'nullable|url|max:255'
        ]);

        try {

            $today = Carbon::now()->toDateString();
    
            $user = Auth::user()->id;
    
            $customers = Customer::create([
                'date_created' => $today,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'address' => $request->address,
                'website' => $request->website,
                'lead_miner' => $user,
                'type' => $request->type,
                'deals' => $request->deals,
                'notes' => $request->notes,
                'verified_by' => $request->verified_by,
                'assign_to' => $request->assign_to,
                'comment' => $request->comment,
    
            ]);

        } catch ( ValidationException $e ) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        
        foreach ($request->contact_numbers as $contact_number) {
            $customers->contactNumbers()->create(['contact_number' => $contact_number, 'status' => 'Not Verified']);
        }
        
        if ($request->books) {
            foreach ($request->books as $book) {
                $customers->books()->create(['title' => $book['title'], 'link' => $book['link']]);
            }
        }
        
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }
    
    public function edit($id, Request $request)
    {
        $statusOptions = ['Not Verified', 'Verified']; 
        $customer = Customer::with('contactNumbers', 'books')->findOrFail($id);
        $statuss = ContactNumber::distinct()->pluck('status')->toArray();

        $referrer = $request->input('referrer', 'index'); // Default to 'index' if no referrer provided

        return view('customers.edit', compact('customer', 'statuss', 'statusOptions', 'referrer'));    
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:customers,email,' . $id,
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'deals' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
            'assign_to' => 'nullable|string|max:255',
            'contact_numbers' => 'required|array',
            'contact_numbers.*.contact_number' => 'required|string|max:255',
            'contact_numbers.*.status' => 'required|string|max:255',
            'books' => 'nullable|array',
            'books.*.title' => 'required|string|max:255',
            'books.*.link' => 'nullable|url|max:255'
        ]);

        try {
            
            $customer = Customer::findOrFail($id);

            $verifiedBy = Auth::user()->profile->fullName();

            $customer->update([
                'first_name'    => $request->first_name,
                'middle_name'   => $request->middle_name,
                'last_name'     => $request->last_name,
                'email'         => $request->email,
                'address'       => $request->address,
                'website'       => $request->website,
                'type'          => $request->type,
                'deals'         => $request->deals,
                'notes'         => $request->notes,
                'assign_to'     => $request->assign_to ?? $customer->assign_to, // Retain existing value if null

            ]);

            $statusUpdated = false;

            // Update contact numbers
            if ($request->has('contact_numbers')) {
                // Get existing contact numbers
                $existingContacts = $customer->contactNumbers->keyBy('contact_number');
    
                foreach ($request->contact_numbers as $contact) {
                    $contactNumber = $contact['contact_number'];
                    $status = $contact['status'] ?? 'Not Verified';
    
                    if (isset($existingContacts[$contactNumber])) {
                        $existingContact = $existingContacts[$contactNumber];
                        
                        if ($existingContact->status !== $status) {
                            // Status changed
                            $existingContact->update(['status' => $status]);
                            $statusUpdated = true;
                        }
                    } else {
                        // Add new contact number
                        $customer->contactNumbers()->create([
                            'contact_number' => $contactNumber,
                            'status' => $status
                        ]);
                    }
                }

                $contactNumbersInRequest = collect($request->contact_numbers)->pluck('contact_number')->toArray();
                $contactsToDelete = $customer->contactNumbers->whereNotIn('contact_number', $contactNumbersInRequest);
                foreach ($contactsToDelete as $contact) {
                    $contact->delete();
                }
            }

            if ($statusUpdated) {
                $customer->update([
                    'verified_by' => auth()->user()->name // Assuming the user is logged in and has a 'name' attribute
                ]);
            }

            // Update books
            if ($request->has('books')) {
                $existingBooks = $customer->books->keyBy('title');

                foreach ($request->books as $book) {
                    $title = $book['title'];
                    $link = $book['link'];

                    if (isset($existingBooks[$title])) {
                        //update existing book
                        $existingBooks[$title]->update(['link' => $link]);
                    } else {
                        // Add new book
                        $customer->books()->create([
                            'title' => $title,
                            'link'  => $link
                        ]);
                    }
                }
                $booksInRequest = collect($request->books)->pluck('title')->toArray();
                $booksToDelete = $customer->books->whereNotIn('title', $booksInRequest);
                foreach ($booksToDelete as $book) {
                    $book->delete();
                }
            }


        } catch (validationException $e ) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        $redirectTo = $request->input('redirect_to', route('customers.index'));

        return redirect($redirectTo)->with('success', 'Customer updated successfully.');
    }

    public function updateStatus(Request $request)
    {

        $request->validate([
            'customer_id' => 'required|integer',
            'contact_numbers.*.number' => 'required|string',
            'contact_numbers.*.status' => 'required|string|in:Not Verified,Verified',
            'contact_numbers.*.id' => 'required|integer'
        ]);

        foreach ($request->contact_numbers as $contact) {
            $contactNumber = ContactNumber::findOrFail($contact['id']);
            $contactNumber->update(['status' => $contact['status']]);
        }

        $customer = Customer::findOrFail($request->customer_id);
        $customer->update(['verified_by' => auth()->user()->id]);

        return redirect()->route('customers.index')->with('success', 'Status updated successfully.');
    }

    public function showAssignForm(Customer $customer)
    {
        $brandingSpecialists = User::whereHas('profile', function ($query) {
            $query->where('des_id', function ($subQuery) {
                $subQuery->select('id')->from('designations')->where('name', 'Branding Specialist');
            });
        })->get();

        return view('customers.assign', compact('customer', 'brandingSpecialists'));
    }

    public function assignEmployees(Request $request)
    {
        $request->validate([
            'customers' => 'required|array',
            'customers.*' => 'exists:customers,id',
            'employees' => 'required|array',
            'employees.*' => 'exists:users,id',
        ]);


        $employees = User::whereIn('id', $request->employees)->get();

        if ($employees->isEmpty()) {
            return redirect()->route('customers.index')->with('error', 'No valid employees found.');
        }

        $employee = $employees->first();


        // Assign each customer to the selected employee
        foreach ($request->customers as $customerId) {
            $customer = Customer::find($customerId);
    
            if ($customer) {
                // Update the `assign_to` field with the employee's ID
                $customer->update(['assign_to' => $employee->id]);

                // Broadcast an event to update the front-end in real-time
                // event(new LeadAssignedToEmployee($customer, $employee->id));
            }
        }

        return redirect()->route('customers.index')->with('success', 'Leads assigned successfully.');
    }

    public function unassignLeads(Request $request)
    {
        $request->validate([
            'customers' => 'required|array',
            'customers.*' => 'exists:customers,id',
        ]);

        foreach ($request->customers as $customerId) {
            $customer = Customer::find($customerId);
            $customer->assign_to = null; // Unassign the user
            $customer->return_lead = false;
            $customer->save();
        }

        return redirect()->route('customers.distro')->with('success', 'Leads unassigned successfully.');
    }

    public function returnToLeadMiner(Request $request)
    {
        $request->validate([
            'customers' => 'required|array',
            'customers.*' => 'exists:customers,id',
            'return_reason' => 'required|string|max:255',
        ]);

        foreach ($request->customers as $customerId) {
            $customer = Customer::find($customerId);

            // Record the return reason
            CustomerReturnReason::create([
                'customer_id' => $customerId,
                'reason' => $request->return_reason,
            ]);

            // Mark lead as returned without changing the assign_to field
            $customer->return_lead = true;
            $customer->save();
        }

        return redirect()->route('employee.mycustomer')->with('success', 'Leads returned to lead miner for correction.');
    }

    public function reassignToEmployee(Request $request)
    {
        \Log::info($request->all());

        // Validate the customers array
        $request->validate([
            'customers' => 'required|array',
            'customers.*' => 'exists:customers,id',  // Ensure each customer ID exists
        ]);

        // Get the array of customer IDs
        $customerIds = $request->input('customers');

        if ($customerIds && is_array($customerIds)) {
            foreach ($customerIds as $customerId) {
                $customer = Customer::find($customerId);

                if ($customer) {
                    $employeeId = $customer->assign_to;

                    if ($employeeId) {
                        $customer->update(['return_lead' => false]);  // Set return_lead to false
                        \Log::info("Customer ID {$customerId} reassigned to employee {$employeeId} and return_lead set to false.");
                    }
                } else {
                    \Log::error("Customer ID {$customerId} not found.");
                }
            }

            return back()->with('success', 'Leads reassigned successfully.');
        }

        return back()->with('error', 'No customers selected for reassignment.');
    }


    public function checkNewLeads()
    {
        // Fetch customers who haven't been viewed yet (for example)
        $newCustomers = Customer::where('is_viewed', false)->get();
        return response()->json(['new_customers' => $newCustomers]);
    }

    public function checkVerifiedLeads()
    {
        // Fetch verified customers
        $verifiedCustomers = Customer::where('verified', true)->get();
        return response()->json(['verified_customers' => $verifiedCustomers]);
    }

    public function checkAssignedLeads()
    {
        // Fetch assigned customers
        $assignedCustomers = Customer::where('is_assigned', true)->get();
        return response()->json(['assigned_customers' => $assignedCustomers]);
    }

    public function checkReturnLeads()
    {
        // Fetch returned leads
        $returnCustomers = Customer::where('is_returned', true)->get();
        return response()->json(['return_customers' => $returnCustomers]);
    }

    public function markAsViewed(Request $request, Customer $customer)
    {
        // Update the customer's 'is_viewed' field to true
        $customer->update(['is_viewed' => true]);

        return response()->json(['success' => true]);
    }


    public function fetchAssignedLeads()
    {
        $assignedCustomers = Customer::with(['contactNumbers', 'books'])
                                    ->whereNotNull('assign_to') // Only include customers who are assigned
                                    ->get();

        return response()->json(['assigned_customers' => $assignedCustomers]);
    }

    public function fetchVerifiedLeads()
    {
        // Fetch verified customers that are not yet assigned
        $verifiedCustomers = Customer::with(['contactNumbers', 'books'])
                                    ->whereHas('contactNumbers', function ($query) {
                                        $query->whereIn('status', ['Verified', 'DNC', 'VM']);
                                    })
                                    ->whereNull('assign_to')
                                    ->get();

        // Return the data in JSON format for AJAX polling
        return response()->json(['verified_customers' => $verifiedCustomers]);
    }

    public function fetchReturnedLeads(Request $request)
    {
        // Get the last check time from the request (if any)
        $lastCheck = $request->input('last_check', now()->subMinute());

        // Fetch leads that were returned after the last check
        $returnCustomers = Customer::with(['contactNumbers', 'books'])
            ->where('return_lead', true)
            ->where('updated_at', '>', $lastCheck) // Only fetch leads updated after the last check
            ->get();

        return response()->json(['return_customers' => $returnCustomers, 'last_check' => now()]);
    }

    public function fetchEmployeeAssignedLeads()
    {
        $userId = Auth::user()->id;

        $assignedCustomers = Customer::with(['contactNumbers', 'books'])
                                    ->where('assign_to', $userId)
                                    ->where('return_lead', false)
                                    ->get();

        return response()->json(['assigned_customers' => $assignedCustomers]);
    }
}

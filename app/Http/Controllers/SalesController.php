<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use App\Models\PackageSold;
use App\Models\PackageType;
use App\Models\Event;
use App\Models\PaymentMethod;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $s_id = $this->generateUniqueID();

        $user = Auth::user();
        $fullName = $user->profile->fullName();
        $packageTypes = PackageType::all();
        $method = PaymentMethod::all();
        return view('sales.create', compact('s_id', 'fullName', 'packageTypes', 'method'));
    }

    public function view($id)
    {
        // Fetch the sale using the ID
        $sale = Sale::findOrFail($id);

        // Return the view with the sale details
        return view('sales.view', compact('sale'));
    }

    public function edit($id) // Accept the sale ID
    {
        $sale = Sale::findOrFail($id); // Fetch a single sale record or fail if not found
        $user = Auth::user();
        $fullName = $user->profile->fullName();
        $packageTypes = PackageType::all();
        $method = PaymentMethod::all();

        return view('sales.edit', compact('sale', 'fullName', 'packageTypes', 'method'));
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->events()->delete();
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale endorsement deleted successfully!');
    }

    public function getPackageSoldByType(Request $request)
    {
        $packageTypeId = $request->input('pack_type_id');
        $packageSold = PackageSold::whereHas('packageType', function ($query) use ($packageTypeId) {
            $query->where('package_type.id', $packageTypeId); // Check the related `PackageType` ID
        })->get();
    

        if ($packageSold->isEmpty()) {
            return response()->json(['message' => 'No packages found for the selected type.'], 404);
        }

        return response()->json($packageSold);
    }


    public function getEventsByPackageSold(Request $request)
    {
        $packageSoldId = $request->input('pack_sold_id');
        $events = Event::whereHas('packageSold', function ($query) use ($packageSoldId) {
            $query->where('package_sold.id', $packageSoldId);
        })->get();

        if ($events->isEmpty()) {
            return response()->json(['message' => 'No events found for the selected package.'], 404);
        }

        return response()->json($events);
    }

    public function store(Request $request)
    {
        // Validate input data
        $validatedData = $request->validate([
            's_id' => 'required|string',
            'date_sold' => 'required|date',
            'consultant_name' => 'required|string|max:255',
            'authors_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'book_title' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'email' => 'required|email',
            'mailing_address' => 'required|string|max:255',
            'package_type' => 'required|string',
            'package_sold' => 'required|string',
            'event_location' => 'required|array',
            'event_location.*' => 'exists:events,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string|max:50',
        ]);

        // Retrieve the package_sold record based on the provided name
        $packageSold = PackageSold::where('id', $validatedData['package_sold'])->first();

        // Check if package_sold exists
        if (!$packageSold) {
            return redirect()->back()->withErrors(['package_sold' => 'Selected package does not exist.']);
        }

        // Calculate the total price (if not handled by JavaScript in the frontend)
        $totalPrice =  $packageSold->price + $validatedData['amount']; // Adjust if needed for custom calculations

        // Create the Sale
        $sale = new Sale();
        $sale->s_id =  $validatedData['s_id']; // You may already have this generated
        $sale->date_sold = $validatedData['date_sold'];
        $sale->consultant = $validatedData['consultant_name'];
        $sale->author_name = $validatedData['authors_name'];
        $sale->gender = $validatedData['gender'];
        $sale->book_title = $validatedData['book_title'];
        $sale->contact_number = $validatedData['contact_number'];
        $sale->email = $validatedData['email'];
        $sale->mailing_address = $validatedData['mailing_address'];
        $sale->pack_type = $validatedData['package_type'];
        $sale->pack_sold = $validatedData['package_sold'];
        $sale->amount = $validatedData['amount'];
        $sale->total_price = $totalPrice;
        $sale->method = $validatedData['method'];
        $sale->save();

        if ($request->event_location) {
            foreach ($request->event_location as $event_location_id) {
                $sale->events()->create([
                    's_id' => $sale->s_id, // Assuming `s_id` is required in `endorsed_event` table
                    'event_name' => $event_location_id, // Adjust this if `event_location` is not `event_name`
                ]);
            }
        }

        // Redirect back with success message
        return redirect()->route('sales.index')->with('success', 'Sale endorsement created successfully!');
    }


    public function getAuthorSuggestions(Request $request)
    {
        $query = $request->input('query');
        $userId = auth()->id(); // Get the authenticated user's ID

        $customers = Customer::where('assign_to', $userId)
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'LIKE', "%$query%")
                ->orWhere('last_name', 'LIKE', "%$query%")
                ->orWhere('lead_miner', 'LIKE', "%$query%");
            })
            ->select(['first_name', 'last_name', 'lead_miner'])
            ->get();

        $suggestions = $customers->map(function ($customer) {
            return [
                'name' => trim($customer->first_name . ' ' . $customer->last_name),
                'lead_miner' => $customer->lead_miner,
            ];
        });

        return response()->json($suggestions);
    }

    public function getBookTitles(Request $request)
    {
        $authorName = $request->query('author_name');
        $nameParts = explode(' ', $authorName, 2);
        $firstName = $nameParts[0] ?? null;
        $lastName = $nameParts[1] ?? null;

        $books = [];

        if ($firstName) {
            $author = Customer::where('first_name', $firstName)
                        ->when($lastName, function ($query) use ($lastName) {
                            return $query->where('last_name', $lastName);
                        })
                        ->with('books')
                        ->first();

            if ($author) {
                $books = $author->books->pluck('title')->toArray();
            }
        }

        return response()->json($books);
    }

    public function generateUniqueID()
    {
        $today = date('Yd');
        $name = "SA";
        do {
            $s_id = $name . $today . rand(100, 999);
        } while(Sale::where('s_id', $s_id)->exists());

        return $s_id;
    }
}

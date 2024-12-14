<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

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
        return view('sales.create', compact('s_id', 'fullName'));
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
        do{
            $s_id = $name . $today . rand(100, 999);
        }while(Sale::where('s_id', $s_id)->exists());

        return $s_id;
    }
}

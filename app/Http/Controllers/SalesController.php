<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sales::paginate(10);
        return view('sales', compact('sales'));
    }
}

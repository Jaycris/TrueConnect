<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PackageSold;
use App\Models\PackageType;
use App\Models\Event;
use App\Models\PaymentMethod;

class PackagesController extends Controller
{
    public function packType()
    {
        $packType = PackageType::paginate(10);
        return view('packages.package-type', compact('packType'));
    }


    public function createPackType()
    {
        $packSold = PackageSold::all(); // Fetch all package sold entries
        return view('packages.package-type-create', compact('packSold'));
    }

    
    public function storePackType(Request $request)
    {
        
        $validatedData = $request->validate([
            'pack_type_name' => 'required|string|max:255',
            'pack_sold'      => 'array', // Validate that it's an array
            'pack_sold.*'    => 'exists:package_sold,id', // Validate that each item exists in the package_sold table
        ]);
        
        $packType = new PackageType([
            'pack_type_name' => $validatedData['pack_type_name'],
        ]);
        $packType->save();

            // Attach the selected package_sold entries to the newly created package_type
        if (!empty($validatedData['pack_sold'])) {
            $packType->packageSold()->attach($validatedData['pack_sold']);
        }
        
        return redirect()->route('pack-type.index')->with('success', 'Package Type saved successfully');
    }

    public function viewPackType($id)
    {
        $packType = PackageType::find($id);

        return view('packages.package-type-view', compact('packType'));
    }
    

    public function editPackType($id)
    {
        $packType = PackageType::find($id);
        $packSold = PackageSold::all();

        return view('packages.package-type-edit', compact('packType', 'packSold'));
    }


    public function updatePackType(Request $request, $id)
    {
        $request->validate([
            'pack_type_name'        => 'required|string|max:255',
            'pack_sold' => 'array', // Validate as an array
            'pack_sold.*' => 'exists:package_sold,id', // Validate each item exists
        ]);

        $packType = PackageType::findOrFail($id);
        $packType->pack_type_name = $request->input('pack_type_name');
        $packType->save();

        $packType->packageSold()->sync($request->input('pack_sold', [])); // Default to empty array if none selected

        return redirect()->route('pack-type.index')->with('success', 'Package Type updated successfully!');
    }


    public function destroyPackType(Request $request, $id)
    {
        $packType = PackageType::find($id);

        if (!$packType) {
            return redirect()->route('pack-type.index')->with('error', 'Package not found.');
        }

        $packType->delete();

        return redirect()->route('pack-type.index')->with('success', 'Package Type deleted successfully!');
    }

    

    public function packSold()
    {
        $packSold = PackageSold::paginate(10);
        return view('packages.package-sold', compact('packSold'));
    }


    public function createPackSold()
    {
        $event = Event::all(); // Fetch all event entries
        return view('packages.package-sold-create', compact('event'));
    }


    public function storePackSold(Request $request)
    {

        $validatedData = $request->validate([
            'pack_sold_name' => 'required|string|max:255',
            'price'          => 'nullable|numeric',
            'events'          => 'array',
            'events.*'    => 'exists:events,id',
        ]);

        $packSold = new PackageSold([
            'pack_sold_name' => $validatedData['pack_sold_name'],
            'price'          => $validatedData['price']
        ]);
        $packSold->save();

        if (!empty($validatedData['events'])) {
            $packSold->event()->attach($validatedData['events']);
        }
    
        return redirect()->route('pack-sold.index')->with('success', 'Package Sold saved successfully!');
    }

    public function viewPackSold($id)
    {
        $packSold = PackageSold::find($id);

        return view('packages.package-sold-view', compact('packSold'));
    }


    public function editPackSold($id)
    {
        $packSold = PackageSold::find($id);
        $event = Event::all();

        return view('packages.package-sold-edit', compact('packSold', 'event'));
    }


    public function updatePackSold(Request $request, $id)
    {
        $request->validate([
            'pack_sold_name'        => 'required|string|max:255',
            'price'          => 'nullable|numeric',
            'events' => 'array', // Validate as an array
            'events.*' => 'exists:events,id', // Validate each item exists
        ]);

        $packSold = PackageSold::findOrFail($id);
        $packSold->pack_sold_name = $request->input('pack_sold_name');
        $packSold->price = $request->input('price');
        $packSold->save();

        $packSold->event()->sync($request->input('events', [])); // Default to empty array if none selected

        return redirect()->route('pack-sold.index')->with('success', 'Package Sold updated successfully!');
    }


    public function destroyPackSold(Request $request, $id)
    {
        $packSold = PackageSold::find($id);

        if (!$packSold) {
            return redirect()->route('pack-sold.index')->with('error', 'Package not found.');
        }

        $packSold->delete();

        return redirect()->route('pack-sold.index')->with('success', 'Package deleted successfully!');
    }


    public function event(){
        $event = Event::paginate(10);
        return view('packages.event', compact('event'));
    }


    public function createEvent()
    {
        return view('packages.event-create');
    }


    public function storeEvent(Request $request)
    {

        $validatedData = $request->validate([
            'event_name' => 'required|string|max:255',
        ]);

        $event = new Event([
            'event_name' => $validatedData['event_name'],
        ]);
        $event->save();
    
        return redirect()->route('events.index')->with('success', 'Package Sold saved successfully!');
    }

    public function viewEvent($id)
    {
        $event = Event::find($id);

        return view('packages.event-view', compact('event'));
    }

    public function editEvent($id)
    {
        $event = Event::find($id);

        return view('packages.event-edit', compact('event'));
    }


    public function updateEvent(Request $request, $id)
    {
        $request->validate([
            'event_name'        => 'required|string|max:255',
        ]);

        $event = Event::find($id);
        $event->event_name = $request->input('event_name');
        $event->save();

        return redirect()->route('events.index')->with('success', 'Event updated');
    }

    public function destroyEvent(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return redirect()->route('events.index')->with('error', 'Event not found.');
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }

    public function method(){
        $method = PaymentMethod::paginate(10);
        return view('packages.method', compact('method'));
    }

    public function createMethod()
    {
        return view('packages.method-create');
    }

    public function storeMethod(Request $request)
    {

        $validatedData = $request->validate([
            'method_name' => 'required|string|max:255',
        ]);

        $method = new PaymentMethod([
            'method_name' => $validatedData['method_name'],
        ]);
        $method->save();
    
        return redirect()->route('method.index')->with('success', 'Payment Method saved successfully!');
    }

    public function viewMethod($id)
    {
        $method = PaymentMethod::find($id);

        return view('packages.method-view', compact('method'));
    }

    public function editMethod($id)
    {
        $method = PaymentMethod::find($id);

        return view('packages.method-edit', compact('method'));
    }

    public function updateMethod(Request $request, $id)
    {
        $request->validate([
            'method_name'        => 'required|string|max:255',
        ]);

        $method = PaymentMethod::find($id);
        $method->method_name = $request->input('method_name');
        $method->save();

        return redirect()->route('method.index')->with('success', 'Payment Method updated');
    }

    public function destroyMethod(Request $request, $id)
    {
        $method = PaymentMethod::find($id);

        if (!$method) {
            return redirect()->route('method.index')->with('error', 'Method not found.');
        }

        $method->delete();

        return redirect()->route('method.index')->with('success', 'Method deleted successfully!');
    }
}

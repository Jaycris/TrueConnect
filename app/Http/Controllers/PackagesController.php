<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PackageSold;
use App\Models\PackageType;
use App\Models\Event;

class PackagesController extends Controller
{
    public function packType()
    {
        $packType = PackageType::paginate(10);
        return view('packages.package-type', compact('packType'));
    }


    public function createPackType()
    {
        return view('packages.package-type-create');
    }

    
    public function storePackType(Request $request)
    {
        
        $validatedData = $request->validate([
            'pack_type_name' => 'required|string|max:255',
        ]);
        
        $packType = new PackageType([
            'pack_type_name' => $validatedData['pack_type_name'],
        ]);
        $packType->save();
        
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

        return view('packages.package-type-edit', compact('packType'));
    }


    public function updatePackType(Request $request, $id)
    {
        $request->validate([
            'pack_type_name'        => 'required|string|max:255',
        ]);

        $packType = PackageType::find($id);
        $packType->pack_type_name = $request->input('pack_type_name');
        $packType->save();

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
        return view('packages.package-sold-create');
    }


    public function storePackSold(Request $request)
    {

        $validatedData = $request->validate([
            'pack_sold_name' => 'required|string|max:255',
        ]);

        $packSold = new PackageSold([
            'pack_sold_name' => $validatedData['pack_sold_name'],
        ]);
        $packSold->save();
    
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

        return view('packages.package-sold-edit', compact('packSold'));
    }


    public function updatePackSold(Request $request, $id)
    {
        $request->validate([
            'pack_sold_name'        => 'required|string|max:255',
        ]);

        $packSold = PackageSold::find($id);
        $packSold->pack_sold_name = $request->input('pack_sold_name');
        $packSold->save();

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
    
        return redirect()->route('pack-sold.index')->with('success', 'Package Sold saved successfully!');
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
}

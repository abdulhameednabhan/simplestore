<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'street' => 'required',
            'building' => 'required',
            'area' => 'required',
        ]);

        Location::create([
            'street' => $request->street,
            'building' => $request->building,
            'area' => $request->area,
            'user_id' => Auth::id(),
        ]);

        return response()->json('Location added', 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'street' => 'required',
            'building' => 'required',
            'area' => 'required',
        ]);

        $location = Location::find($id);

        if ($location) {
            $location->street = $request->street;
            $location->building = $request->building;
            $location->area = $request->area;
            $location->save();
            return response()->json('Location updated');
        } else {
            return response()->json('Location not found', 404);
        }
    }
    public function destroy($id)
    {
        $location = Location::find($id);
    
        if ($location) {
            $location->delete();
            return response()->json('Location deleted', 204);
        } else {
            return response()->json('Location not found', 404);
        }
    }
}
 
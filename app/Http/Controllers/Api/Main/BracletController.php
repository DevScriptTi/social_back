<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use App\Models\Api\Main\Braclet;
use App\Models\Api\Main\Location;
use Illuminate\Http\Request;

class BracletController extends Controller
{
    public function index()
    {
        return response()->json([
            Braclet::with(['children','location','circle'])->paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        $braclet = Braclet::create($request->all());
        return response()->json([
            'message' => 'Braclet created successfully',
            'data'=>$braclet->load(['children','location','circle'])
        ]);
    }

    public function show(Braclet $braclet)
    {
        return response()->json([
            $braclet->load(['children','location','circle'])
        ]);
    }


    public function update(Request $request, Braclet $braclet)
    {
        $braclet->update($request->all());
        return response()->json([
            'message' => 'Braclet updated successfully',
            'data'=>$braclet->load(['children','location','circle'])
        ]);

    }

    public function destroy(Braclet $braclet)
    {
        $braclet->delete();
        return response()->json([
            'message' => 'Braclet deleted successfully'
        ]);
    }

    public function updateLocation(Request $request,Location $location){
        $location->update($request->all());
        return response()->json([
            'message' => 'Location updated successfully',
            'data'=>$location->fresh()
        ]);
    }
}

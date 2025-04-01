<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use App\Models\Api\Main\Children;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChildrenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            Children::with(['gurdian','braclet'=>['location' ,'circle.location' ],'baladya.wilaya'])->paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        $username = Str::slug($request->input('name') . '.' . $request->input('last')) . rand(10000, 99999);
        $request->merge(['username' => $username]);
        $child = Children::create($request->all());
        return response()->json([
            'message' => 'Children created successfully',
            'data' => $child->load(['gurdian','braclet'=>['location' ,'circle.location' ],'baladya.wilaya'])
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Children $children)
    {
        return response()->json([
            $children->load(['braclet'=>['location' ,'circle.location' ],'baladya.wilaya'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Children $children)
    {

        $children->update($request->all());
        return response()->json([
            'message' => 'Children updated successfully'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Children $children)
    {
        $children->delete();
        return response()->json([
            'message' => 'Children deleted successfully'
        ]);
    }
}

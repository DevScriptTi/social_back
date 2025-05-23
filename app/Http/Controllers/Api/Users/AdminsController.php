<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\Api\Users\SuperAdmin;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $admins = SuperAdmin::with(['key.user', 'photo'])
            ->when($request->has('username'), function ($query) use ($request) {
                $query->where('username', 'like', '%' . $request->username . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(6);
        return response()->json($admins);
    }


    public function store(Request $request)
    {
        // Log::info($request->all());
        $validated = $request->validate([
            'name' => 'required|string',
            'last' => 'required|string',
        ]);


        $admin = SuperAdmin::create([
            'username' => $validated['name'] . '_' . $validated['last'] . '_' . str()->random(6),
            'name' => $validated['name'],
            'last' => $validated['last'],
        ]);

        return response()->json([
            'message' => 'Admin created successfully',
            'admin' => $admin->load('key.user', 'photo')
        ], 201);
    }

    public function createKey(SuperAdmin $admin)
    {
        $admin->key()->create([
            'value' => str()->random(10),
        ]);

        return response()->json([
            'message' => 'Key created successfully',
            'key' => $admin->key->value,
            'photo' => $admin->photo
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(SuperAdmin $admin)
    {
        return response()->json([
            'message' => 'Admin fetched successfully',
            'admin' => $admin->load('key.user', 'photo')
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuperAdmin $admin)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'last' => 'required|string',
        ]);
        $validated['username'] = $validated['name'] . '_' . $validated['last'] . '_' . str()->random(6);
        $admin->update($validated);
        return response()->json([
            'message' => 'Admin updated successfully',
            'admin' => $admin->load('key.user', 'photo')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuperAdmin $admin)
    {
        $admin->photo()->delete();
        $admin->key()->delete();
        $admin->delete();
        return response()->json([
            'message' => 'Admin deleted successfully'
        ], 200);
    }
}

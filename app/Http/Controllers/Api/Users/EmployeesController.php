<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\Api\Main\Photo;
use App\Models\Api\Users\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EmployeesController extends Controller
{

    public function index(Request $request)
    {
        $query = Employee::with([
            'photo',
            'key.user'
        ])
        ->withCount('applications'); // Assuming 'applications' is the relationship

        if ($request->has('username')) {
            $query->where('username', 'like', '%' . $request->username . '%');
        }

        $employees = $query->paginate(6);

        return response()->json([
            'status' => 'success',
            'data' => $employees
        ]);
    }

    public function show(Employee $employee)
    {
        $employee->load(['photo', 'key.user']);
        return response()->json([
            'status' => 'success',
            'data' => $employee
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'last' => 'required',
            'date_of_birth' => 'required|date',
        ]);

        // Generate username from name, last and random string
        $username = strtolower($validated['name'] . $validated['last'] . str()->random(4));

        // Ensure username is unique
        while (Employee::where('username', $username)->exists()) {
            $username = strtolower($validated['name'] . $validated['last'] . str()->random(4));
        }

        $validated['username'] = $username;
        $user = User::where('id', Auth::id())->first();
        $validated['committee_id'] = $user->key->keyable_id;
        $employee = Employee::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Employee created successfully',
            'data' => $employee
        ], 201);
    }

    public function storePhoto(Request $request, Employee $employee)
    {
        $request->validate([
            'photo' => 'required|image|max:2048'
        ]);

        if ($employee->photo) {
            Storage::delete($employee->photo->path);
            $employee->photo->delete();
        }

        $path = $request->file('photo')->store('employees', 'public');

        $photo = new Photo(['path' => $path]);
        $employee->photo()->save($photo);

        return response()->json([
            'status' => 'success',
            'message' => 'Photo uploaded successfully',
            'data' => $photo
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required',
            'last' => 'required',
            'date_of_birth' => 'required|date',
            'committee_id' => 'sometimes|required|exists:committees,id'
        ]);

        // Generate new username from name, last and random string
        $username = strtolower($validated['name'] . $validated['last'] . str()->random(4));

        // Ensure username is unique (excluding current employee)
        while (Employee::where('username', $username)->where('id', '!=', $employee->id)->exists()) {
            $username = strtolower($validated['name'] . $validated['last'] . str()->random(4));
        }

        $validated['username'] = $username;
        $employee->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Employee updated successfully',
            'data' => $employee
        ]);
    }

    public function updatePhoto(Request $request, Employee $employee)
    {
        $request->validate([
            'photo' => 'required|image|max:2048'
        ]);

        if ($employee->photo) {
            Storage::delete($employee->photo->path);
            $employee->photo->delete();
        }

        $path = $request->file('photo')->store('employees', 'public');

        $photo = new Photo(['path' => $path]);
        $employee->photo()->save($photo);

        return response()->json([
            'status' => 'success',
            'message' => 'Photo updated successfully',
            'data' => $photo
        ]);
    }

    public function createKey(Employee $employee)
    {
        $key = $employee->key()->create([
            'value' => str()->random(10),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Key created successfully',
            'data' => $key
        ]);
    }

    public function destroy(Employee $employee)
    {
        DB::transaction(function () use ($employee) {
            // Delete photo
            if ($employee->photo) {
                Storage::delete($employee->photo->path);
                $employee->photo->delete();
            }

            // Delete key and associated user
            if ($employee->key) {
                if ($employee->key->user) {
                    $employee->key->user->delete();
                }
                $employee->key->delete();
            }

            $employee->delete();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Employee and all associated data deleted successfully'
        ]);
    }
}

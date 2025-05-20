<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\Api\Users\Committee;
use App\Models\Api\Core\Key;
use App\Models\Api\Main\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CommitteeController extends Controller
{
    public function index(Request $request)
    {
        $query = Committee::with(['daira.wilaya', 'photo', 'key.user'])
            ->withCount(['employees', 'applicants']);

        if ($request->has('username')) {
            $query->where('username', 'like', '%' . $request->username . '%');
        }

        $committees = $query->paginate(6);

        return response()->json([
            'status' => 'success',
            'data' => $committees
        ]);
    }

    public function show(Committee $committee)
    {
        $committee->load(['daira.wilaya', 'photo', 'key.user'])
            ->loadCount(['employees', 'applicants']);

        return response()->json([
            'status' => 'success',
            'data' => $committee
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'last' => 'required',
            'date_of_birth' => 'required|date',
            'daira_id' => 'required|exists:dairas,id'
        ]);

        // Generate username from name, last and random string
        $username = strtolower($validated['name'] . $validated['last'] . str()->random(4));
        
        // Ensure username is unique
        while (Committee::where('username', $username)->exists()) {
            $username = strtolower($validated['name'] . $validated['last'] . str()->random(4));
        }

        $validated['username'] = $username;
        $committee = Committee::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Committee created successfully',
            'data' => $committee
        ], 201);
    }

    public function storePhoto(Request $request, Committee $committee)
    {
        $request->validate([
            'photo' => 'required|image|max:2048'
        ]);

        if ($committee->photo) {
            Storage::delete($committee->photo->path);
            $committee->photo->delete();
        }

        $path = $request->file('photo')->store('committees', 'public');
        
        $photo = new Photo(['path' => $path]);
        $committee->photo()->save($photo);

        return response()->json([
            'status' => 'success',
            'message' => 'Photo uploaded successfully',
            'data' => $photo
        ]);
    }

    public function update(Request $request, Committee $committee)
    {
        $validated = $request->validate([
            'name' => 'required',
            'last' => 'required',
            'date_of_birth' => 'required|date',
            'daira_id' => 'required|exists:dairas,id'
        ]);

        // Generate new username from name, last and random string
        $username = strtolower($validated['name'] . $validated['last'] . str()->random(4));
        
        // Ensure username is unique (excluding current committee)
        while (Committee::where('username', $username)->where('id', '!=', $committee->id)->exists()) {
            $username = strtolower($validated['name'] . $validated['last'] . str()->random(4));
        }

        $validated['username'] = $username;
        $committee->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Committee updated successfully',
            'data' => $committee
        ]);
    }

    public function updatePhoto(Request $request, Committee $committee)
    {
        $request->validate([
            'photo' => 'required|image|max:2048'
        ]);

        if ($committee->photo) {
            Storage::delete($committee->photo->path);
            $committee->photo->delete();
        }

        $path = $request->file('photo')->store('committees', 'public');
        
        $photo = new Photo(['path' => $path]);
        $committee->photo()->save($photo);

        return response()->json([
            'status' => 'success',
            'message' => 'Photo updated successfully',
            'data' => $photo
        ]);
    }

    public function createKey(Committee $committee)
    {
        $key = $committee->key()->create([
            'value' => str()->random(10),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Key created successfully',
            'data' => $key
        ]);
    }

    public function destroy(Committee $committee)
    {
        DB::transaction(function () use ($committee) {
            // Delete photo
            if ($committee->photo) {
                Storage::delete($committee->photo->path);
                $committee->photo->delete();
            }

            // Delete key and associated user
            if ($committee->key) {
                $committee->key->user->delete();
                $committee->key->delete();
            }

            // Delete applicants and their applications
            foreach ($committee->applicants as $applicant) {
                $applicant->applications()->delete();
                $applicant->delete();
            }

            // Delete employees, their keys and users
            foreach ($committee->employees as $employee) {
                if ($employee->key) {
                    $employee->key->user->delete();
                    $employee->key->delete();
                }
                $employee->delete();
            }

            // Finally delete the committee
            $committee->delete();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Committee and all associated data deleted successfully'
        ]);
    }
} 
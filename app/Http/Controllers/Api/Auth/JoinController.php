<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Api\Core\Key;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JoinController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => ["required", "email", "unique:users,email"],
            'password' => ["required", "string"],
            'key' => ["required", "string", "exists:keys,value"]
        ]);

        $key = Key::where("value", $request->post('key'))->first();

        if ($key->status == "used") {
            return response()->json(["message" => "This key is alrdy used", "errors" => ["key" => ["This key is alrdy used"]]], 403);
        }
        $key->status = "used";
        $key->save();
        $key->user()->create($request->only(['email', 'password']));
        return response()->json(["message" => "user registred succes"], 200);
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => ["required", "email", "exists:users,email"],
            'password' => ["required", "string"]
        ]);

        if (!Auth::attempt(['email' => $request->post('email'), 'password' => $request->post('password')])) {
            return response()->json(["message" => "user not found", "errors" => ["password" => ["password is incorrect"]]], 403);
        }

        $user = Auth::user();
        $user = $user instanceof User ? $user : User::find($user->id);
        $token = $user->createToken('token')->plainTextToken;
        return response()->json([
            "token" => $token,
            "user" => $user->load('key.keyable.photo')
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(["message" => "logout success"], 200);
    }
}

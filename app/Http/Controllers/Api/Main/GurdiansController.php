<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use App\Models\Api\Extra\Phone;
use Illuminate\Http\Request;
use App\Models\Api\User\Gurdian;
use Illuminate\Support\Str;


class GurdiansController extends Controller
{
    public function index()
    {
        $gurdians = Gurdian::with(['phones' ,'baladya.wilaya' ,'key.user' ])->paginate(10);
        return response()->json($gurdians);
    }

    public function show(Gurdian $gurdian)
    {
        return response()->json($gurdian->fresh(['phones' ,'baladya.wilaya' ,'key.user']));
    }

    public function store(Request $request)
    {
        $username = Str::slug($request->input('name') . '.' . $request->input('last')) . rand(10000, 99999);
        $request->merge(['username' => $username]);
        $gurdian = Gurdian::create($request->all());
        return response()->json($gurdian, 201);
    }

    public function storePhone(Request $request , Gurdian $gurdian)
    {
        $phone = $gurdian->phones()->create($request->all());
        return response()->json($phone, 201);
    }


    public function update(Request $request, Gurdian $gurdian)
    {
        $gurdian->update($request->all());
        return response()->json($gurdian);
    }

    public function updatePhone(Request $request, Gurdian $gurdian , Phone $phone)
    {
        $phone->update($request->all());
        return response()->json($phone);
    }

    public function destroy(Gurdian $gurdian)
    {
        $gurdian->phones()->delete();
        $gurdian->delete();
        return response()->json(['message' => 'Gurdian deleted successfully']);
    }

    public function createKey(Gurdian $gurdian)
    {
        $key = Str::random(32);
        $gurdian->key()->create(['value' => $key]);
        return response()->json(['api_key' => $key]);
    }
}

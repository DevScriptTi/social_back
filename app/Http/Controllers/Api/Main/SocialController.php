<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use App\Models\Api\Main\Application;
use App\Models\Api\Main\Social;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{

    public function index()
    {
        $socials = Social::paginate(10);
        return response()->json(['status' => 'success', 'data' => $socials, 'message' => 'Socials fetched successfully'], 200);
    }

    public function evaluate(Social $social)
    {
        $notClassedApplications = Application::where('status', 'not-classed')
            ->orderBy('grade', 'desc')
            ->get();

        $count = $notClassedApplications->count();
        $i = $social->number_of_application;
        while ($i < $count && $i < $social->max_application) {
            $application = $notClassedApplications[$i];
            $application->status = 'accepted';
            $application->social_id = $social->id;
            $application->save();
            $i++;
        }

        $social->number_of_application = $i;
        $social->save();

        return response()->json([
            'status' => 'success',
            'message' => $count . ' applications evaluated successfully',
            'data' => [
                'social' => $social->load('applications'),
                'evaluated_count' => $count
            ]
        ], 200);
    }

    public function getApplications(Social $social)
    {
        $applications = $social->applications()->with(['applicant' => ['wife', 'photo'], 'housing', 'files', 'health', 'professional', 'qrcode'])->orderBy('grade', 'desc')->paginate(10);
        return response()->json([
            'status' => 'success',
            'data' => $applications,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_application' => 'required|integer',
        ]);
        $request->merge(['number_of_application' => 0]);
        $request->merge(['committee_id' => User::find(Auth::user()->id)->key->keyable_id]);
        $social = Social::create($request->all());
        return response()->json(['status' => 'success', 'data' => $social, 'message' => 'Social created successfully'], 200);
    }

    public function show(string $id)
    {
        $social = Social::find($id);
        return response()->json(['status' => 'success', 'data' => $social, 'message' => 'Social fetched successfully'], 200);
    }

    public function update(Request $request, string $id)
    {
        $social = Social::find($id);
        $social->update($request->all());
        return response()->json(['status' => 'success', 'data' => $social, 'message' => 'Social updated successfully'], 200);
    }

    public function destroy(string $id)
    {
        $social = Social::find($id);
        $social->delete();
        return response()->json(['status' => 'success', 'message' => 'Social deleted successfully'], 200);
    }
}

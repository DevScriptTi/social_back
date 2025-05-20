<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use App\Models\Api\Main\Applicant;
use App\Models\Api\Main\Application;
use App\Models\Api\Users\Committee;
use App\Models\User;
use FFI\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Application::with(['applicant']);

        if (request()->query('national_id_number')) {
            $query->whereHas('applicant', function ($q) {
                $q->where('national_id_number', request()->query('national_id_number'));
            });
        }
        $applications = $query->paginate(6);
        return response()->json([
            'applications' => $applications,
        ], 200);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'national_id_number' => 'required|string|max:255|unique:applicants,national_id_number',
        ]);




        DB::beginTransaction();
        try {
            $applicant = Applicant::create($validated);
            $applicant->application()->create([
                'date' => now(),
                'key' =>  random_int(100000, 999999),
            ]);
            $applicant->application->health()->create();
            $applicant->application->professional()->create();
            $applicant->application->housing()->create();
            $applicant->application->files()->create();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'حدث خطأ أثناء تقديم الطلب',
                'error' => $e->getMessage(),
            ], 500);
        }
        return response()->json([
            'message' => 'تم تقديم الطلب بنجاح',
            'application' => $applicant->application->load(['applicant' => ['wife', 'committee']]),
        ], 201);
    }

    public function show(Application $application)
    {
        $application->load(['applicant' => ['wife', 'photo'], 'committee.daira.wilaya', 'housing', 'files', 'health', 'professional', 'qrcode']);
        return response()->json([
            'application' => $application,
        ], 200);
    }

    public function updateCivleStatus(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
            'national_id_number' => 'required|string|max:255|unique:applicants,national_id_number',
            'residence_place' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:applicants,email',
            'phone' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'status' => 'required|in:single,married,divorced,widowed',
            'children_number' => 'required|integer|min:0|max:65535',
            'committee_id' => 'sometimes|required|integer|exists:committees,id',
        ]);
        $wifeValidate = $request->validate([
            'wife.name' => 'sometimes|required|string|max:255',
            'wife.last' => 'sometimes|required|string|max:255',
            'wife.date_of_birth' => 'sometimes|required|date',
            'wife.place_of_birth' => 'sometimes|required|string|max:255',
            'wife.national_id_number' => 'sometimes|required|string|max:255',
            'wife.residence_place' => 'sometimes|required|string|max:255',
        ]);



        DB::beginTransaction();
        try {
            $committee = Committee::find($validated['committee_id']);
            $applicant = Applicant::create($validated);
            $applicant->committee()->associate($committee);
            $applicant->save();
            if ($wifeValidate) {
                $applicant->wife()->create([
                    'name' => $wifeValidate['wife']['name'],
                    'last' => $wifeValidate['wife']['last'],
                    'date_of_birth' => $wifeValidate['wife']['date_of_birth'],
                    'place_of_birth' => $wifeValidate['wife']['place_of_birth'],
                    'national_id_number' => $wifeValidate['wife']['national_id_number'],
                    'residence_place' => $wifeValidate['wife']['residence_place'],
                ]);
            }
            $applicant->application()->create([
                'date' => now(),
                'key' =>  random_int(100000, 999999),
                'committee_id' => $committee->id,
            ]);
            $applicant->application->health()->create();
            $applicant->application->professional()->create();
            $applicant->application->housing()->create();
            $applicant->application->files()->create();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'حدث خطأ أثناء تقديم الطلب',
                'error' => $e->getMessage(),
            ], 500);
        }
        return response()->json([
            'message' => 'تم تقديم الطلب بنجاح',
            'application' => $applicant->application->load(['applicant' => ['wife', 'committee']]),
        ], 201);
    }

    public function updateProfessional(Request $request)
    {
        $validated = $request->validate([
            'is_employed' => 'sometimes|required|boolean',
            'work_nature' => 'sometimes|nullable|string|max:255',
            'current_job' => 'sometimes|nullable|string|max:255',
            'monthly_income' => 'sometimes|nullable|numeric|min:0',
            'application_id' => 'required|integer|exists:applications,id',
            'key' => 'required|integer|exists:applications,key',
        ]);

        $application = Application::where('key', $validated['key'])->first();

        $professional = $application->professional;
        $professional->update($validated);

        return response()->json([
            'message' => 'Professional information updated successfully.',
            'professional' => $professional,
        ], 200);
    }

    public function updateHousing(Request $request)
    {
        $validated = $request->validate([
            'current_housing_type' => 'required|string|max:255',
            'previously_benefited' => 'required|boolean',
            'housing_area' => 'nullable|numeric|min:0',
            'other_properties' => 'nullable|string|max:255',
            'application_id' => 'required|integer|exists:applications,id',
            'key' => 'required|integer|exists:applications,key',
        ]);

        $application = Application::where('key', $validated['key'])->first();

        if (!$application) {
            return response()->json([
                'message' => 'Application not found.',
            ], 404);
        }

        $housing = $application->housing;
        $housing->update([
            'current_housing_type' => $validated['current_housing_type'],
            'previously_benefited' => $validated['previously_benefited'],
            'housing_area' => $validated['housing_area'] ?? null,
            'other_properties' => $validated['other_properties'] ?? null,
        ]);

        return response()->json([
            'message' => 'Housing information updated successfully.',
            'housing' => $housing,
        ], 200);
    }

    public function updateHealth(Request $request)
    {
        $validated = $request->validate([
            'chronic_illness_disability' => 'sometimes|required|boolean',
            'type' => 'sometimes|nullable|string|max:255',
            'family_member_illness' => 'sometimes|nullable|boolean',
            'relationship' => 'sometimes|nullable|string|max:255',
            'application_id' => 'required|integer|exists:applications,id',
            'key' => 'required|integer|exists:applications,key',
        ]);

        $application = Application::where('key', $validated['key'])->first();

        if (!$application) {
            return response()->json([
                'message' => 'Application not found.',
            ], 404);
        }

        $health = $application->health;
        $health->update([
            'chronic_illness_disability' => $validated['chronic_illness_disability'],
            'type' => $validated['type'] ?? null,
            'family_member_illness' => $validated['family_member_illness'] ?? null,
            'relationship' => $validated['relationship'] ?? null,
        ]);

        return response()->json([
            'message' => 'Health information updated successfully.',
            'health' => $health,
        ], 200);
    }

    public function updateFiles(Request $request)
    {
        $validated = $request->validate([
            'application_id' => 'required|integer|exists:applications,id',
            'key' => 'required|integer|exists:applications,key',
            'birth_certificate' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'spouse_birth_certificate' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'family_individual_certificate' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'applicant_national_id' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'spouse_national_id' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'residence_certificate' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'employment_unemployment_certificate' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'spouse_employment_certificate' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'spouse_salary_certificate' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'applicant_salary_certificate' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'non_real_estate_ownership_certificate' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'medical_certificate' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'death_divorce_certificate' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $application = Application::where('key', $validated['key'])->first();

        if (!$application) {
            return response()->json([
                'message' => 'Application not found.',
            ], 404);
        }

        $files = $application->files;
        $fields = [
            'birth_certificate',
            'spouse_birth_certificate',
            'family_individual_certificate',
            'applicant_national_id',
            'spouse_national_id',
            'residence_certificate',
            'employment_unemployment_certificate',
            'spouse_employment_certificate',
            'spouse_salary_certificate',
            'applicant_salary_certificate',
            'non_real_estate_ownership_certificate',
            'medical_certificate',
            'death_divorce_certificate',
        ];

        $updateData = [];
        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('files', $filename, 'public');
                $updateData[$field] = $path;
            }
        }

        $files->update($updateData);

        return response()->json([
            'message' => 'Files updated successfully.',
            'files' => $files,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

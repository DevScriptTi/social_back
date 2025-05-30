<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use App\Models\Api\Main\Applicant;
use App\Models\Api\Main\Application;
use App\Models\User;
use FFI\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

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

        if (request()->query('status')) {
            $query->where('status', request()->query('status'));
        }

        if (request()->query('sort') === 'grade') {
            $query->orderBy('grade', request()->query('order', 'desc'));
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $applications = $query->paginate(10);
        return response()->json([
            'applications' => $applications,
        ], 200);
    }


    public function show(Application $application)
    {
        $application->load(['applicant' => ['wife', 'photo'],  'housing', 'files', 'health', 'professional', 'qrcode']);
        return response()->json([
            'application' => $application,
        ], 200);
    }

    public function update(Application $application)
    {
        $application->calculateGrade();
        $application->status = 'not-classed';
        $application->save();
        return response()->json([
            'message' => 'Grade calculated successfully',
            'application' => $application->load(['applicant' => ['wife', 'photo'], 'housing', 'files', 'health', 'professional', 'qrcode']),
        ], 200);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'national_id_number' => 'required|string|max:255',
        ]);

        $applicant = Applicant::where('national_id_number', $validated['national_id_number'])->first();
        if ($applicant) {
            return response()->json([
                'message' => 'applicant already exists',
                'application' => $applicant->application->load(['applicant' => ['wife', 'photo'],  'housing', 'files', 'health', 'professional', 'qrcode']),
            ], 200);
        }

        $validated['committee_id'] = 1;

        DB::beginTransaction();
        try {
            $applicant = Applicant::create($validated);
            $applicant->application()->create([
                'date' => now(),
                'key' =>  str()->random(10),
                'committee_id' => 1,
            ]);
            $applicant->wife()->create();
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
            'application' => $applicant->application->load(['applicant' => ['wife', 'photo'],  'housing', 'files', 'health', 'professional', 'qrcode']),
        ], 201);
    }

    public function applicant(Request $request, Application $application)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
            'residence_place' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'status' => 'required|in:single,married,divorced,widowed',
            'children_number' => 'required|integer|min:0|max:65535',
        ]);
        $wifeValidate = null;
        if ($request->has('wife') && $request->status == 'married') {
            $wifeValidate = $request->validate([
                'wife.name' => 'sometimes|required|string|max:255',
                'wife.last' => 'sometimes|required|string|max:255',
                'wife.date_of_birth' => 'sometimes|required|date',
                'wife.place_of_birth' => 'sometimes|required|string|max:255',
                'wife.national_id_number' => 'sometimes|required|string|max:255',
                'wife.residence_place' => 'sometimes|required|string|max:255',
            ]);
        }

        DB::beginTransaction();
        try {
            $application->applicant()->update($validated);
            if ($application->step <= 1) {
                $application->step = 1;
                $application->errors = [];
                $application->save();
            }
            if ($wifeValidate) {
                $wife = $application->applicant->wife()->first();
                $wife->update([
                    'name' => $wifeValidate['wife']['name'],
                    'last' => $wifeValidate['wife']['last'],
                    'date_of_birth' => $wifeValidate['wife']['date_of_birth'],
                    'place_of_birth' => $wifeValidate['wife']['place_of_birth'],
                    'national_id_number' => $wifeValidate['wife']['national_id_number'],
                    'residence_place' => $wifeValidate['wife']['residence_place'],
                ]);
            }
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
            'application' => $application->load(['applicant' => ['wife', 'photo'], 'housing', 'files', 'health', 'professional', 'qrcode']),
        ], 201);
    }


    public function professional(Request $request, Application $application)
    {
        $validated = $request->validate([
            'is_employed' => 'sometimes|required',
            'work_nature' => 'sometimes|nullable|string|max:255',
            'current_job' => 'sometimes|nullable|string|max:255',
            'monthly_income' => 'sometimes|nullable|numeric|min:0',
        ]);

        if ($application->step <= 2) {
            $application->step = 2;
            $application->save();
        }

        $professional = $application->professional;
        $professional->update($validated);

        return response()->json([
            'message' => 'Professional information updated successfully.',
            'application' => $application->load(['applicant' => ['wife', 'photo'], 'housing', 'files', 'health', 'professional', 'qrcode']),
        ], 200);
    }

    public function housing(Request $request, Application $application)
    {
        $validated = $request->validate([
            'current_housing_type' => 'required|in:non_residential_place,collapsing_communal,collapsing_private,with_relatives_or_rented,functional_housing',
            'previously_benefited' => 'required|in:yes,no', // Changed from boolean to enum validation
            'housing_area' => 'nullable|numeric|min:0|max:999999.99', // Matches decimal(8,2)
            'other_properties' => 'nullable|string', // Changed from max:255 to text
        ]);

        if ($application->step <= 3) {
            $application->step = 3;
            $application->save();
        }
        $housing = $application->housing;
        $housing->update($validated);

        return response()->json([
            'message' => 'Housing information updated successfully.',
            'application' => $application->load(['applicant' => ['wife', 'photo'], 'housing', 'files', 'health', 'professional', 'qrcode']),
        ], 200);
    }

    public function health(Request $request, Application $application)
    {
        $validated = $request->validate([
            'chronic_illness_disability' => 'sometimes|required|in:yes,no', // Changed from boolean to enum
            'type' => 'sometimes|nullable|string|max:255',
            'family_member_illness' => 'sometimes|nullable|in:yes,no', // Changed from boolean to enum
            'relationship' => 'sometimes|nullable|string|max:255',
        ]);

        if ($application->step <= 4) {
            $application->step = 4;
            $application->save();
        }

        $health = $application->health;
        $health->update($validated);

        return response()->json([
            'message' => 'Health information updated successfully.',
            'application' => $application->load(['applicant' => ['wife', 'photo'], 'housing', 'files', 'health', 'professional', 'qrcode']),
        ], 200);
    }


    public function files(Request $request, Application $application)
    {
        // Map field names to their corresponding file numbers
        $fieldFileMap = [
            'birth_certificate' => 'file1',
            'spouse_birth_certificate' => 'file2',
            'family_individual_certificate' => 'file3',
            'applicant_national_id' => 'file4',
            'spouse_national_id' => 'file5',
            'residence_certificate' => 'file6',
            'employment_unemployment_certificate' => 'file7',
            'spouse_employment_certificate' => 'file8',
            'spouse_salary_certificate' => 'file9',
            'applicant_salary_certificate' => 'file10',
            'non_real_estate_ownership_certificate' => 'file11',
            'medical_certificate' => 'file12',
            'death_divorce_certificate' => 'file13',
        ];

        // Ensure directories exist
        $sourceDir = public_path('filesCopy/');
        $destinationDir = public_path('files/');

        if (!File::exists($destinationDir)) {
            File::makeDirectory($destinationDir, 0755, true);
        }

        // Process each file
        $fileData = [];
        foreach ($fieldFileMap as $field => $sourceFileBase) {
            $sourceFile = $sourceDir . $sourceFileBase . '.webp';
            $newFilename = $field . '_' . $application->key . '.webp';
            $destinationFile = $destinationDir . $newFilename;

            if (File::exists($sourceFile)) {
                // Copy and rename the file
                File::copy($sourceFile, $destinationFile);
                $fileData[$field] = $newFilename;
            } else {
                \Log::warning("Source file not found: " . $sourceFile);
                $fileData[$field] = null;
            }
        }

        // Update application step if needed
        if ($application->step <= 5) {
            $application->step = 5;
            $application->status = "on-review";
            $application->save();
        }

        // Update files with the new filenames
        $application->files->update($fileData);

        return response()->json([
            'message' => 'Files copied and renamed successfully.',
            'application' => $application->load(['applicant' => ['wife', 'photo'], 'housing', 'files', 'health', 'professional', 'qrcode']),
        ], 200);
    }

    public function destroy(Application $application)
    {
        $application->delete();
    }
}

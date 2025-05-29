<?php

namespace App\Models\Api\Main;

use App\Models\Api\Users\Committee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;
use App\Models\Api\Main\QrCode;
use App\Models\Api\Users\Employee;

class Application extends Model
{
    protected $fillable = [
        'date',
        'status',
        'classment',
        'grade',
        'description',
        'key',
        'applicant_id',
        'employee_id',
        'committee_id',
        'errors',
        'step',
    ];

    protected static function booted()
    {
        static::addGlobalScope('committee_employees', function ($query) {
            $user = User::find(Auth::id());
            $type = $user->key->keyable_type ?? null;
            if ($user && $type === 'employee') {
                $query->where('employee_id', $user->key->keyable_id);
            } elseif ($user && $type === 'committee') {
                $query->where('committee_id', $user->key->keyable_id);
            }
        });
        static::created(function ($application) {
            // Generate QR code image and store in public/qrcode
            $fileName = 'qrcode_' . $application->applicant->national_id_number . '.png';
            $filePath = public_path('qrcode/' . $fileName);

            // Ensure the directory exists
            if (!file_exists(public_path('qrcode'))) {
                mkdir(public_path('qrcode'), 0755, true);
            }

            // Generate and save the QR code image
            QrCodeGenerator::format('png')->size(200)->generate($application->applicant->national_id_number, $filePath);

            QrCode::create([
                'value' => asset('qrcode/' . $fileName),
                'application_id' => $application->id,
            ]);
        });
    }

    public function getRouteKeyName()
    {
        return 'key';
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function professional()
    {
        return $this->hasOne(Professional::class);
    }

    public function housing()
    {
        return $this->hasOne(Housing::class);
    }

    public function files()
    {
        return $this->hasOne(File::class);
    }

    public function health()
    {
        return $this->hasOne(Health::class);
    }


    public function qrCode()
    {
        return $this->hasOne(QrCode::class);
    }

    //  'is_employed',
    //     'work_nature',
    //     'current_job',
    //     'monthly_income',
    //     'application_id',
    // =======================
    // 'current_housing_type',
    //     'previously_benefited',
    //     'housing_area',
    //     'other_properties',
    //     'application_id'
    public function calculateGrade()
    {
        $salaryGrade = 0;
        if ($this->professional->monthly_income <= 12000) {
            $salaryGrade += 30;
        } elseif ($this->professional->monthly_income > 12000 && $this->professional->monthly_income <= 18000) {
            $salaryGrade = 25;
        } elseif ($this->professional->monthly_income > 18000 && $this->professional->monthly_income <= 24000) {
            $salaryGrade = 15;
        }
        $housingGrade = 0;
        if ($this->housing->current_housing_type == 'non_residential_place') {
            $housingGrade += 50;
        } elseif ($this->housing->current_housing_type == 'collapsing_communal') {
            $housingGrade += 50;
        } elseif ($this->housing->current_housing_type == 'collapsing_private') {
            $housingGrade += 30;
        } elseif ($this->housing->current_housing_type == 'with_relatives_or_rented') {
            $housingGrade += 25;
        } elseif ($this->housing->current_housing_type == 'functional_housing') {
            $housingGrade += 15;
        }
        $socialGrade = 0;
        // 'single', 'married', 'divorced', 'widowed'
        if ($this->applicant->status == 'single') {
            $socialGrade += 8;
        } else {
            $socialGrade += 10;
        }
        $socialGrade += $this->applicant->children_number * 2;
        if ($this->health->chronic_illness_disability == 'yes') {
            $socialGrade += 30;
        }
        $socialGrade += $this->calculateYearsPoints();
        $this->grade = $salaryGrade + $housingGrade + $socialGrade;
        $this->save();
    }


    public function calculateYearsPoints()
    {
        // تأكد أن تاريخ السكن موجود
        if (!$this->date) {
            return 0;
        }

        $years = Carbon::parse($this->date)->diffInYears(now());

        if ($years >= 5 && $years <= 8) {
            return 30;
        } elseif ($years > 8 && $years <= 10) {
            return 35;
        } elseif ($years > 10 && $years <= 15) {
            return 40;
        } elseif ($years > 15) {
            return 50;
        }

        return 0; // أقل من 5 سنوات
    }
}

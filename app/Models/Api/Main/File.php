<?php

namespace App\Models\Api\Main;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'birth_certificate', 'spouse_birth_certificate',
        'family_individual_certificate', 'applicant_national_id',
        'spouse_national_id', 'residence_certificate',
        'employment_unemployment_certificate', 'spouse_employment_certificate',
        'spouse_salary_certificate', 'applicant_salary_certificate',
        'non_real_estate_ownership_certificate', 'medical_certificate',
        'death_divorce_certificate', 'application_id'
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}

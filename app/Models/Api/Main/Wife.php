<?php

namespace App\Models\Api\Main;

use Illuminate\Database\Eloquent\Model;

class Wife extends Model
{
    protected $fillable = [
        'name', 'last', 'date_of_birth', 'place_of_birth',
        'national_id_number', 'residence_place', 'applicant_id'
    ];

    public function getRouteKeyName()
    {
        return 'national_id_number';
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function photo()
    {
        return $this->morphOne(Photo::class, 'photoable');
    }


}

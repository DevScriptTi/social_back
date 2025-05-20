<?php

namespace App\Models\Api\Main;

use App\Models\Api\Users\Committee;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'name', 'last', 'date_of_birth', 'place_of_birth',
        'national_id_number', 'residence_place', 'email', 'phone',
        'gender', 'status', 'children_number', 'committee_id'
    ];



    public function application()
    {
        return $this->hasOne(Application::class);
    }

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }


    public function wife()
    {
        return $this->hasOne(Wife::class);
    }

    public function photo()
    {
        return $this->morphOne(Photo::class, 'photoable');
    }

}

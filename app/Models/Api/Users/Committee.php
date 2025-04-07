<?php

namespace App\Models\Api\Users;

use App\Models\Api\Core\Daira;
use App\Models\Api\Core\Key;
use App\Models\Api\Main\Applicant;
use App\Models\Api\Main\Photo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Committee extends Model
{
    protected $fillable = [
        'username', 'name', 'last', 'date_of_birth', 'daira_id'
    ];

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function daira()
    {
        return $this->belongsTo(Daira::class);
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function photo()
    {
        return $this->morphOne(Photo::class, 'photoable');
    }

    public function key(){
        return $this->morphOne(Key::class,"keyable");
    }

}

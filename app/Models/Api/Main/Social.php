<?php

namespace App\Models\Api\Main;

use App\Models\Api\Users\Committee;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $fillable = ['name', 'number_of_application', 'max_application', 'committee_id'];

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }

    public function applications(){
        return $this->hasMany(Application::class);
    }

    public function getMaxApplicationGrades($limit = 10)
    {
        $grades = Application::orderBy('grade', 'desc')->limit($limit)->get();
        return $grades;
    }
}

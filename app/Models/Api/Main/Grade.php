<?php

namespace App\Models\Api\Main;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['value', 'application_id'];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    // Helper method
    public function formattedGrade()
    {
        return number_format($this->value, 2);
    }

    public function evaluate(){}

}

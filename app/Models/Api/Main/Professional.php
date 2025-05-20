<?php

namespace App\Models\Api\Main;

use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{

    protected $fillable = [
        'is_employed',
        'work_nature',
        'current_job',
        'monthly_income',
        'application_id',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}

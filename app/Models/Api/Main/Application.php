<?php

namespace App\Models\Api\Main;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'date', 'status', 'classment', 'grade', 'description',
        'applicant_id', 'employee_id', 'social_id'
    ];

    public function getRouteKeyName()
    {
        return 'id';
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

    public function grade()
    {
        return $this->hasOne(Grade::class);
    }

    public function qrCode()
    {
        return $this->hasOne(QrCode::class);
    }
}

<?php

namespace App\Models\Api\Main;

use Illuminate\Database\Eloquent\Model;

class Housing extends Model
{
    protected $fillable = [
        'current_housing_type',
        'previously_benefited',
        'housing_area',
        'other_properties',
        'application_id'
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    // Helper methods
    public function housingTypeLabel()
    {
        return [
            'rental' => 'إيجار',
            'owned' => 'ملكية',
            'family housing' => 'سكن عائلي'
        ][$this->current_housing_type] ?? $this->current_housing_type;
    }
}

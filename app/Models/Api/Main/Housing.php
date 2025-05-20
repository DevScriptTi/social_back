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



    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    // Helper methods
    public function housingTypeLabel()
    {
        return [
            'non_residential_place' => 'محل غير مخصص للسكن',
            'collapsing_communal' => 'سكن مهدد بالانهيار ',
            'collapsing_private' => 'سكن مهدد بالانهيار - ملك فردي',
            'with_relatives_or_rented' => 'سكن عند الأقارب أو عند الغير أو سكن مؤجر',
            'functional_housing' => 'سكن وظيفي	'
        ][$this->current_housing_type] ?? $this->current_housing_type;
    }
}

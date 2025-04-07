<?php

namespace App\Models\Api\Main;

use Illuminate\Database\Eloquent\Model;

class Health extends Model
{
    protected $fillable = [
        'chronic_illness_disability',
        'type',
        'family_member_illness',
        'relationship',
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
    public function hasCondition()
    {
        return $this->chronic_illness_disability === 'yes';
    }

    public function familyHasCondition()
    {
        return $this->family_member_illness === 'yes';
    }
}

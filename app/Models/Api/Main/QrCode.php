<?php

namespace App\Models\Api\Main;

use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
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
}

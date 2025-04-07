<?php

namespace App\Models\Api\Main;

use App\Models\Api\Users\Committee;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $fillable = ['date', 'number', 'committee_id'];

    public function getRouteKeyName()
    {
        return 'number'; // Using social number as route key
    }

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }



}

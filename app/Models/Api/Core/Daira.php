<?php

namespace App\Models\Api\Core;

use App\Models\Api\Users\Committee;
use Illuminate\Database\Eloquent\Model;

class Daira extends Model
{
    protected $fillable = ['name', 'wilaya_id'];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function wilaya()
    {
        return $this->belongsTo(Wilaya::class);
    }

    public function committee()
    {
        return $this->hasOne(Committee::class);
    }
}

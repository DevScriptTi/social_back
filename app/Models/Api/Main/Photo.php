<?php

namespace App\Models\Api\Main;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['path'];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function photoable()
    {
        return $this->morphTo();
    }
}

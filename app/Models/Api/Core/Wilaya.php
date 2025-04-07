<?php

namespace App\Models\Api\Core;

use Illuminate\Database\Eloquent\Model;

class Wilaya extends Model
{
    protected $fillable = ['name'];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function dairas()
    {
        return $this->hasMany(Daira::class);
    }
}

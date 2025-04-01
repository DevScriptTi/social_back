<?php

namespace App\Models\Api\Main;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['lat', 'lng'];
    public function locationable(){
        return $this->morphTo();
    }
}

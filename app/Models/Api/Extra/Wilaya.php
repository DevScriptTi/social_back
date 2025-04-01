<?php

namespace App\Models\Api\Extra;

use Illuminate\Database\Eloquent\Model;

class Wilaya extends Model
{
    protected $fillable = ['name'];
    public function baladya(){
        return $this->hasMany(Baladya::class);
    }
}

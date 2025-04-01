<?php

namespace App\Models\Api\Extra;

use App\Models\Api\Main\Children;
use App\Models\Api\User\Gurdian;
use Illuminate\Database\Eloquent\Model;

class Baladya extends Model
{
    protected $fillables = ['name', 'wilaya_id'];

    public function wilaya(){
        return $this->belongsTo(Wilaya::class);
    }

    public function gurdians(){
        return $this->hasMany(Gurdian::class);
    }
    public function Children(){
        return $this->hasMany(Children::class);
    }
}

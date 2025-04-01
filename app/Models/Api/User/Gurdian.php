<?php

namespace App\Models\Api\User;

use App\Models\Api\Extra\Baladya;
use App\Models\Api\Extra\Key;
use App\Models\Api\Extra\Phone;
use App\Models\Api\Main\Children;
use Illuminate\Database\Eloquent\Model;

class Gurdian extends Model
{
    protected $fillable = ['username','name' ,'last', 'date_of_birth' , 'baladya_id'];

    public function key(){
        return $this->morphOne(Key::class, 'keyable');
    }

    public function baladya(){
        return $this->belongsTo(Baladya::class);
    }

    public function phones(){
        return $this->morphMany(Phone::class, 'phoneable');
    }

    public function  childrens(){
        return $this->hasMany(Children::class);
    }

    public function getRouteKeyName()
    {
        return 'username';
    }
}

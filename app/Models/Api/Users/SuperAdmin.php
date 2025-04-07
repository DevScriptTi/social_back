<?php

namespace App\Models\Api\Users;

use App\Models\Api\Core\Key;
use Illuminate\Database\Eloquent\Model;

class SuperAdmin extends Model
{
    protected $fillable = ['username', 'name', 'last', 'is_super'];

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function photo()
    {
        return $this->morphOne(\App\Models\Api\Main\Photo::class, 'photoable');
    }
    public function key(){
        return $this->morphOne(Key::class,"keyable");
    }
}

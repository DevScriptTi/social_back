<?php

namespace App\Models\Api\User;

use App\Models\Api\Extra\Key;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = ['username'];

    public function key(){
        return $this->morphOne(Key::class, 'keyable');
    }

}

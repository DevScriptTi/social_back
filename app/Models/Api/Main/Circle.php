<?php

namespace App\Models\Api\Main;

use Illuminate\Database\Eloquent\Model;

class Circle extends Model
{
    protected $fillable = ['radius' , 'braclet_id'];
    public function braclet(){
        return $this->belongsTo(Braclet::class);
    }
    public function location(){
        return $this->morphOne(Location::class, 'locationable');
    }
}

<?php

namespace App\Models\Api\Extra;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = ['number'];

    public function phoneable(){
        return $this->morphTo();
    }
}

<?php

namespace App\Models\Api\Main;

use App\Models\Api\Extra\Baladya;
use App\Models\Api\User\Gurdian;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Children extends Model
{
    protected $fillable = ['username', 'name', 'last' ,'date_of_birth' , 'description' ,'baladya_id' ,'gurdian_id' ];

    protected static function booted()
    {
        static::addGlobalScope('gurdian', function (Builder $builder) {
            $user = User::find(Auth::id());
            if (Auth::check() && $user->key->keyable_type === 'gurdian') {
                $builder->where('gurdian_id', $user->key->keyable_id);
            }
        });

        static::creating(function ($child) {
            $user = User::find(Auth::id());
            if (Auth::check() && $user->key->keyable_type === 'gurdian') {
               $child->gurdian_id = $user->key->keyable_id;
            }
        });
        static::updating(function ($child) {
            $user = User::find(Auth::id());
            if (Auth::check() && $user->key->keyable_type === 'gurdian') {
                $child->gurdian_id = $user->key->keyable_id;
            }
        });
    }

    public function gurdian(){
        return $this->belongsTo(Gurdian::class);
    }
    public function baladya(){
        return $this->belongsTo(Baladya::class);
    }

    public function braclet(){
        return $this->hasOne(Braclet::class);
    }

    public function getRouteKeyName()
    {
        return 'username';
    }
}

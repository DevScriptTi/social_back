<?php

namespace App\Models\Api\Users;

use App\Models\Api\Core\Daira;
use App\Models\Api\Core\Key;
use App\Models\Api\Main\Application;
use App\Models\Api\Main\Photo;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Employee extends Model
{
    protected $fillable = [
        'username',
        'name',
        'last',
        'date_of_birth',
        'committee_id',
    ];

    protected static function booted()
    {
        static::addGlobalScope('committee_employees', function ($query) {
            $user = User::where('id', Auth::id())->first();
            $type = $user->key->keyable_type ?? null;
            if ($user && $type === 'committee') {
                $query->where('committee_id', $user->key->keyable_id);
            }
        });

        static::creating(function ($employee) {
            $user = User::where('id', Auth::id())->first();
            $type = $user->key->keyable_type ?? null;
            if ($user && $type === 'committee') {
                $employee->committee_id = $user->key->keyable_id;
            }
        });
    }


    public function applications()
    {
        return $this->hasMany(Application::class);
    }
   

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }

    public function photo()
    {
        return $this->morphOne(Photo::class, 'photoable');
    }

    public function key()
    {
        return $this->morphOne(Key::class, "keyable");
    }
}

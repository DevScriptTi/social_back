<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Api\Extra\Key;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Testing\Fluent\Concerns\Has;
use Laravel\Sanctum\HasApiTokens;
use PhpParser\Node\Expr\Cast;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable ,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        'key_id',
    ];

    public function key(){
        return $this->belongsTo(Key::class);
    }
    protected $casts = [
        'password'=> 'hashed'
    ];

    public function isGurdian(){
        return $this->key && $this->key->keyable_type === 'gurdian';
    }

    public function userProfile(){
        $key = $this->key->keyable_type;

    }

}

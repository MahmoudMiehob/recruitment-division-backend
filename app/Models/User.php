<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Statue;
use App\Models\Transaction;
use App\Models\Userinformation;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function userinfo()
    {
        return $this->hasOne(Userinformation::class,'user_id','id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'role_user');
    }

    public function statue()
    {
        return $this->belongsTo(Statue::class);
    }




    //jwt function 

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }    

}

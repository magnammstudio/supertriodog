<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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
        'isAdmin',
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
        'id'=>'string',
        'isAdmin'=>'bool',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function vet(){
        return $this->hasMany(vet::class,'user_id','id');
    }

    public function isVet(){
        $isVet = $this->vet()->count()>0;
        return $isVet;
    }
    public function haveNoVet(){
        $isVet = $this->vet()->count()==0;
        return $isVet;
    }
}

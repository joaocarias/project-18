<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function profissional(){
        return $this->belongsTo(Profissional::class, 'id', 'user_id');
    }

    public function passwordDefault(){
        return '12345678';
    }

    public function regras()
    {
        return $this->belongsToMany(Regra::class, 'user_regras', 'user_id', 'regra_id');
    }
}

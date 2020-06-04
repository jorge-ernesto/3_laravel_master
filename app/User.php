<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table      = "users";
    protected $primaryKey = "id";
    public $timestamps    = true;
    
    protected $fillable = [
        'role',
        'name',
        'surname',
        'nick',        
        'email',
        'password',
        'image'
    ];
    
    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];
}

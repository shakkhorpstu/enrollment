<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'users';

    protected $fillable = [
        'first_name', 'last_name', 'father_name', 'mother_name', 'email', 'faculty_id', 'registration_no', 'id_no', 'session',
        'city', 'full_address', 'password', 'verify_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function faculty(){
        return $this->belongsTo('App\Faculty');
    }

    public function Hall(){
        return $this->belongsTo('App\Hall');
    }
}

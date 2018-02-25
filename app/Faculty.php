<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = [
        'faculty_name', 'faculty_id',
    ];

    public function user(){
    	return $this->hasMany('App\User');
    }

    public function enroll(){
    	return $this->hasmany('App\Enroll');
    }
}

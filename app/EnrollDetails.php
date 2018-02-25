<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnrollDetails extends Model
{
    public function enroll(){
    	return $this->belongsTo('App\Enroll');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}

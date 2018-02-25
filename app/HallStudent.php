<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HallStudent extends Model
{
    protected $fillable = ['name', 'id_no', 'reg_no', 'hall_id', 'payment_status'];
}

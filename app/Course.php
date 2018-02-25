<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['faculty_name','course_id','course_title','credit','semester'];
}

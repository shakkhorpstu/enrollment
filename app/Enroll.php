<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Course;

class Enroll extends Model
{
    protected $table = 'enrolls';

    public function faculty(){
    	return $this->belongsTo('App\Faculty');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }

    // public function fails($course_id){
    //   $student_id = Auth::User()->id_no;
    //   $faculty_id = Auth::User()->faculty_id;
    //   $courses = DB::table('courses')->where('course_id',$course_id);
    //   $course_credit = $courses->credit;
    //   $id = DB::table('course_enroll')->insertGetId(
    //     ['email' => 'john@example.com', 'votes' => 0]
    //   );
    // }
}

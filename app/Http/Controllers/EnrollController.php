<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Enroll;
use App\User;
use App\Faculty;
use App\Course;
use App\Hall;
use App\HallStudent;

class EnrollController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     // fitrst form => semester form
     public function semesterInfo()
     {
        return view('user-view.enrollFormFirst');
     }



     // no use of this function
     // second form => regular information for selected semester
    public function regularInfo(Request $request)
    {
        $semester = $request->semester;
        $faculty = Auth::User()->faculty_id;
        $courses = DB::table('courses')->where('semester',$semester)
        ->where('faculty_name',$faculty)
        ->get();

        $credit_value = 75;
        $admission_fee = 300;
        $generator_fee = 120;
        $course_credit = 0;
        $regular_courses = array();

        foreach($courses as $course){
          $regular_courses = $course->course_id;
          // calculating total course credit
          $course_credit = $course_credit + $course->credit;
        }
        // calculating total amount
        $total_amount = $credit_value * $course_credit + $admission_fee + $generator_fee;

        return view('user-view.enrollForm')->with("semester",$semester)->with("total_amount",$total_amount)->withCourses($courses);
    }

    // third form => repeat course informaton including regular course information
    public function fiInfo(Request $request){
        $year = date('Y');
        $student_id = Auth::User()->id_no;

        // spliting level & semester
        $level_semester = $request->level_semester;
        $split_level_semester = explode("-", $level_semester);
        $level = $split_level_semester[0];
        $semester = $split_level_semester[1];

        $already_completed = DB::table('enrolls')->where('semester',$semester)
        ->where('enroll_year',$year)
        ->where('id_no',$student_id)
        ->first();

        if($already_completed){
          session()->flash('complete-message', 'You are already enrolled for this semester');
          return redirect()->route('enrollform');
        }
        else{
          $faculty = Auth::User()->faculty_id;
        $student_id = Auth::User()->id_no;
        $credit_value = 75;
        $repeat_course_credit = 0;
        $admission_fee = 300;
        $generator_fee = 120;
        $total_amount = 0;

        $repeat_courses_one = array();
        $repeat_courses_two = array();
        $repeat_courses_three = array();

        $courses = DB::table('courses')->where('level', $level)
            ->where('semester', $semester)
            ->where('faculty_name', $faculty)
            ->get();
        foreach($courses as $course){
          $total_amount = $total_amount + ($credit_value * $course->credit);
        }
        $total_amount = $total_amount + $admission_fee + $generator_fee;

        // retrieve repeat course of logged in student
        if($level > 1){
          for($lvl=1; $lvl<$level; $lvl++){
            if($lvl == 1){
              $repeat_courses_one = DB::table('repeat_course')
                ->where('level', $lvl)
                ->where('semester', $semester)
                ->where('student_id', $student_id)
                ->get();
            }
            if($lvl == 2){
              $repeat_courses_two = DB::table('repeat_course')
                ->where('level', $lvl)
                ->where('semester', $semester)
                ->where('student_id', $student_id)
                ->get();
            }
            if($lvl == 3){
              $repeat_courses_three = DB::table('repeat_course')
                ->where('level', $lvl)
                ->where('semester', $semester)
                ->where('student_id', $student_id)
                ->get();
            }
          }

            if(empty($repeat_courses_one)){
              $repeat_courses_one = array();
            }
            if(empty($repeat_courses_two)){
              $repeat_courses_two = array();
            }
            if(empty($repeat_courses_three)){
              $repeat_courses_three = array();
            }

          return view('user-view.fiForm')->with("total_amount",$total_amount)->with("semester",$semester)
          ->withCourses($courses)->with("level",$level)->withRepeatcoursesone($repeat_courses_one)
          ->withRepeatcoursestwo($repeat_courses_two)->withRepeatcoursesthree($repeat_courses_three);
        }

        return view('user-view.fiForm')->with("total_amount",$total_amount)->with("semester",$semester)
        ->withCourses($courses)->with("level",$level)->withRepeatcoursesone($repeat_courses_one)
        ->withRepeatcoursestwo($repeat_courses_two)->withRepeatcoursesthree($repeat_courses_three);
        }
    }

    // final form => selected repeat course by student including regular course information
    public function finalInfo(Request $request){
      $repeat_lists_one = $request->remove_repeat_course_one;
      $repeat_lists_two = $request->remove_repeat_course_two;
      $repeat_lists_three = $request->remove_repeat_course_three;
      $total_amount = $request->total_amount;
      $total_regular_amount = $total_amount;
      $total_repeat_amount = 0;
      $semester = $request->semester;
      $level = $request->level;

      $faculty = Auth::User()->faculty_id;
      $student_id = Auth::User()->id_no;
      $hall_id = Auth::User()->hall_id;
      $total_repeat_credit = 0;
      $total_course_credit = 0;
      $credit_value = 75;

      $hall = Hall::find($hall_id);

      // checking student select repeat course or not
      if(empty(count($repeat_lists_one)) && empty(count($repeat_lists_two)) && empty(count($repeat_lists_three))){
        $repeat_lists_one = array();
        $repeat_lists_two = array();
        $repeat_lists_three = array();
        $total_repeat_credit = 0;
        $total_repeat_amount = 0;
        $regular_courses = DB::table('courses')->where('semester',$semester)
        ->where('level',$level)
        ->where('faculty_name',$faculty)
        ->get();
        return view('user-view.finalForm')->with("regular_courses",$regular_courses)->with("total_regular_amount",$total_regular_amount)
        ->with("total_repeat_credit",$total_repeat_credit)->with("total_repeat_amount",$total_repeat_amount)
        ->with("semester",$semester)->with("total_amount",$total_amount)->with("level",$level)
        ->with("repeat_courses_one",$repeat_lists_one)->with("repeat_courses_two",$repeat_lists_two)
        ->with("repeat_courses_three",$repeat_lists_three)->withHall($hall);
      }
      else{
        if(isset($repeat_lists_one)){
          foreach($repeat_lists_one as $repeat_course_code_one){
            $repeat_courses_one = DB::table('courses')
            ->where('course_id', $repeat_course_code_one)
            ->first();
            $total_repeat_credit = $total_repeat_credit + $repeat_courses_one->credit;
          }
        }
        if(isset($repeat_lists_two)){
          foreach($repeat_lists_two as $repeat_course_code_two){
            $repeat_courses_two = DB::table('courses')
            ->where('course_id', $repeat_course_code_two)
            ->first();
            $total_repeat_credit = $total_repeat_credit + $repeat_courses_two->credit;
          }
        }
        if(isset($repeat_lists_three)){
          foreach($repeat_lists_three as $repeat_course_code_three){
            $repeat_courses_three = DB::table('courses')
            ->where('course_id', $repeat_course_code_three)
            ->first();
            $total_repeat_credit = $total_repeat_credit + $repeat_courses_three->credit;
          }
        }
        if(empty($repeat_lists_one)){
          $repeat_lists_one = array();
        }
        if(empty($repeat_lists_two)){
          $repeat_lists_two = array();
        }
        if(empty($repeat_lists_three)){
          $repeat_lists_three = array();
        }

        // foreach($repeat_lists_one as $repeat_course_code_one){
        //   $repeat_courses_one = DB::table('courses')
        //   ->where('course_id', $repeat_course_code_one)
        //   ->first();
        //   $total_repeat_credit = $total_repeat_credit + $repeat_courses->credit;
        // }
        //
        // foreach($repeat_lists_two as $repeat_course_code_two){
        //   $repeat_courses_two = DB::table('courses')
        //   ->where('course_id', $repeat_course_code_two)
        //   ->first();
        //   $total_repeat_credit = $total_repeat_credit + $repeat_courses_two->credit;
        // }
        //
        // foreach($repeat_lists_three as $repeat_course_code_three){
        //   $repeat_courses_three = DB::table('courses')
        //   ->where('course_id', $repeat_course_code_three)
        //   ->first();
        //   $total_repeat_credit = $total_repeat_credit + $repeat_courses_three->credit;
        // }

        $total_repeat_amount = $total_repeat_amount + ($total_repeat_credit * $credit_value);

        $total_amount = $total_amount + $total_repeat_amount;

        $regular_courses = DB::table('courses')->where('semester',$semester)
        ->where('level',$level)
        ->where('faculty_name',$faculty)
        ->get();

        return view('user-view.finalForm')->with("regular_courses",$regular_courses)->with("total_regular_amount",$total_regular_amount)
        ->with("total_repeat_credit",$total_repeat_credit)->with("total_repeat_amount",$total_repeat_amount)
        ->with("semester",$semester)->with("total_amount",$total_amount)->with("level",$level)
        ->with("repeat_courses_one",$repeat_lists_one)->with("repeat_courses_two",$repeat_lists_two)
        ->with("repeat_courses_three",$repeat_lists_three)->withHall($hall);
      }
      // else{
      //   $repeat_lists = array();
      //   $total_repeat_credit = 0;
      //   $total_repeat_amount = 0;
      //   $regular_courses = DB::table('courses')->where('semester',$semester)
      //   ->where('faculty_name',$faculty)
      //   ->get();
      //   return view('user-view.finalForm')->with("regular_courses",$regular_courses)->with("repeat_courses",$repeat_lists)
      //   ->with("total_regular_amount",$total_regular_amount)->with("total_repeat_credit",$total_repeat_credit)
      //   ->with("total_repeat_amount",$total_repeat_amount)->with("semester",$semester)->with("total_amount",$total_amount);
      // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // save student enrollment information in both table regular course & repeat course(if has)
    public function store(Request $request)
    {
        $repeat_courses_one = $request->repeat_course_one;
        $repeat_courses_two = $request->repeat_course_two;
        $repeat_courses_three = $request->repeat_course_three;
        $hall_id = $request->hall_id;
        $allot_id = $request->hall_allot_id;

        $total_amount = $request->total_amount;

        $first_name = Auth::user()->first_name;
        $last_name = Auth::user()->last_name;
        $name = $first_name.' '.$last_name;
        $faculty_id = Auth::user()->faculty_id;
        $student_id = Auth::user()->id_no;
        $student_reg = Auth::user()->registration_no;

        // Regular Students
        $faclty = DB::table('faculties')->where('faculty_id', $faculty_id)->first();

        $enroll = new Enroll();

        $semester = $request->semester;
        $level = $request->level;
        $year = date('Y');

        $enroll->id_no = $student_id;
        $enroll->name = $name;
        $enroll->faculty = $faclty->faculty_name;
        $enroll->level = $level;
        $enroll->semester = $semester;
        $enroll->enroll_year = $year;
        $enroll->amount = $request->total_amount;
        $enroll->hall_id = $hall_id;
        $enroll->hall_pay_status = 0;
        $enroll->confirm = 0;
        $enroll->transaction_id = $request->transaction_id;
        $enroll->phone_number = $request->phone_number;

        $regular_courses = DB::table('courses')->where('semester',$semester)
        ->where('level',$level)
        ->where('faculty_name',$faculty_id)
        ->get();

        $enroll->save();

        // add hall wise student information
        $hall = DB::table('hall_student')->insertGetId(
          ['name' => $name, 'id_no' => $student_id, 'reg_no' => $student_reg, 'hall_id' => $hall_id, 'allot_id' => $allot_id, 'faculty_id' => $faculty_id, 'payment_status' => 0]
        );

        $year = date('Y');
        // checking student has repeat course or not
        if(count($repeat_courses_one) > 0){
          foreach($repeat_courses_one as $repeat_list_one){
            $courses = DB::table('courses')->where('course_id',$repeat_list_one)->first();
            $course_credit = $courses->credit;
            $course_level = $courses->level;
            $course_semester = $courses->semester;
            $id = DB::table('course_enroll')->insertGetId(
              ['student_id' => $student_id, 'course_id' => $repeat_list_one, 'level' => $course_level,
                 'semester' => $semester, 'course_credit' => $course_credit, 'confirm' => 0, 'enroll_year' => $year]
            );
          }
        }

        if(count($repeat_courses_two) > 0){
          foreach($repeat_courses_two as $repeat_list_two){
            $courses = DB::table('courses')->where('course_id',$repeat_list_two)->first();
            $course_credit = $courses->credit;
            $course_level = $courses->level;
            $course_semester = $courses->semester;
            $id = DB::table('course_enroll')->insertGetId(
              ['student_id' => $student_id, 'course_id' => $repeat_list_two, 'level' => $course_level,
                 'semester' => $semester, 'course_credit' => $course_credit, 'confirm' => 0, 'enroll_year' => $year]
            );
          }
        }

        if(count($repeat_courses_three) > 0){
          foreach($repeat_courses_three as $repeat_list_three){
            $courses = DB::table('courses')->where('course_id',$repeat_list_three)->first();
            $course_credit = $courses->credit;
            $course_level = $courses->level;
            $course_semester = $courses->semester;
            $id = DB::table('course_enroll')->insertGetId(
              ['student_id' => $student_id, 'course_id' => $repeat_list_three, 'level' => $course_level, 'semester' => $semester, 'course_credit' => $course_credit, 'confirm' => 0, 'enroll_year' => $year]
            );
          }
        }

        session()->flash('success', 'Your Enrollment Information Successfully Send To PSTU Administration.Please Wait For Confirmation.Thank You');

        return redirect()->route('enrollform');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

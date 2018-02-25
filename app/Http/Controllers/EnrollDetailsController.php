<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;
use App\User;
use App\Faculty;
use App\Enroll;
use App\Admin;
use Mail;

class EnrollDetailsController extends Controller
{

    public function __construct(){
        $this->middleware('auth:admin');
    }

    


    // Retrieve level & semester enrolled list
    public function facultyEnrollment($level,$semester)
    {
        $level_split = explode("-",$level);
        $level = $level_split[1];
        $semester_split = explode("-",$semester);
        $semester = $semester_split[1];
        $year = date('Y');

        // Retrieve admin faculty_name
        $admin_faculty_name = Auth::User()->admin_faculty;

        // Retrieve required level & semester enrolled list(Only Admin's Faculty)
        $enrolls = DB::table('enrolls')->where('faculty', $admin_faculty_name)
                                ->where('level', $level)
                                ->where('semester', $semester)
                                ->where('confirm', 0)
                                ->where('enroll_year', $year)
                                ->get();

        $confirm = 0;                        
        return view('admin.enrolllist',compact('enrolls','level','semester','confirm'));
    }





    public function completedEnrollList($level,$semester)
    {
        $level_split = explode("-",$level);
        $level = $level_split[1];
        $semester_split = explode("-",$semester);
        $semester = $semester_split[1];
        $year = date('Y');

        // Retrieve admin faculty_name
        $admin_faculty_name = Auth::User()->admin_faculty;

        // Retrieve required level & semester enrolled list(Only Admin's Faculty)
        $enrolls = DB::table('enrolls')->where('faculty', $admin_faculty_name)
                                ->where('level', $level)
                                ->where('semester', $semester)
                                ->where('confirm', 1)
                                ->where('enroll_year', $year)
                                ->get();

        $confirm = 1;
        return view('admin.enrolllist',compact('enrolls','level','semester','confirm'));
    }

    


    public function repeat(Request $request, $student_id)
    {
        $level = $request->level;
        $semester = $request->semester;
        $year = date('Y');

        // Retrieve Student's repeat list
        $repeat_courses_one = DB::table('course_enroll')
        ->where('student_id',$student_id)
        ->where('level',($level-1))
        ->where('semester',$semester)
        ->where('confirm',0)
        ->where('enroll_year', $year)
        ->get();

        $repeat_courses_two = DB::table('course_enroll')
        ->where('student_id',$student_id)
        ->where('level',($level-2))
        ->where('semester',$semester)
        ->where('confirm',0)
        ->where('enroll_year', $year)
        ->get();

        $repeat_courses_three = DB::table('course_enroll')
        ->where('student_id',$student_id)
        ->where('level',($level-3))
        ->where('semester',$semester)
        ->where('confirm',0)
        ->where('enroll_year', $year)
        ->get();

        // $repeat_courses_length_one = count($repeat_courses_one);
        // $repeat_courses_length_two = count($repeat_courses_two);
        // $repeat_courses_length_three = count($repeat_courses_three);
        if(empty($repeat_courses_one)){
          $repeat_courses_one = array();
        }
        if(empty($repeat_courses_two)){
          $repeat_courses_two = array();
        }
        if(empty($repeat_courses_three)){
          $repeat_courses_three = array();
        }
        // if(empty($repeat_courses_length_one) && empty($repeat_courses_length_two) && empty($repeat_courses_length_three)){
        //   $repeat_courses_one = array();
        //   $repeat_courses_two = array();
        //   $repeat_courses_three = array();
        //   return view('admin.repeatCourse')->withRepeatcoursesone($repeat_courses_one)->withRepeatcoursestwo($repeat_courses_two)
        //   ->withRepeatcoursesthree($repeat_courses_three);
        // }
        return view('admin.repeatCourse')->withRepeatcoursesone($repeat_courses_one)->withRepeatcoursestwo($repeat_courses_two)
        ->withRepeatcoursesthree($repeat_courses_three)->withStudentid($student_id);
    }






    public function completedRepeat(Request $request, $student_id)
    {
        $level = $request->level;
        $semester = $request->semester;
        $year = date('Y');

        // Retrieve Student's repeat list
        $repeat_courses_one = DB::table('course_enroll')
        ->where('student_id',$student_id)
        ->where('level',($level-1))
        ->where('semester',$semester)
        ->where('confirm',1)
        ->where('enroll_year',$year)
        ->get();

        $repeat_courses_two = DB::table('course_enroll')
        ->where('student_id',$student_id)
        ->where('level',($level-2))
        ->where('semester',$semester)
        ->where('confirm',1)
        ->where('enroll_year',$year)
        ->get();

        $repeat_courses_three = DB::table('course_enroll')
        ->where('student_id',$student_id)
        ->where('level',($level-3))
        ->where('semester',$semester)
        ->where('confirm',1)
        ->where('enroll_year',$year)
        ->get();

        if(empty($repeat_courses_one)){
          $repeat_courses_one = array();
        }
        if(empty($repeat_courses_two)){
          $repeat_courses_two = array();
        }
        if(empty($repeat_courses_three)){
          $repeat_courses_three = array();
        }

        return view('admin.repeatCourse')->withRepeatcoursesone($repeat_courses_one)->withRepeatcoursestwo($repeat_courses_two)
        ->withRepeatcoursesthree($repeat_courses_three)->withStudentid($student_id);
    }




    // Delete Enrolled Student from list
    public function destroy($id)
    {
        DB::table('enrolls')->where('id','=',$id)->delete();

        session()->flash('delete', 'Successfully Deleted');

        return redirect()->route('admin.faculty.enrolllist');
    }





    // Mail to enroll completed student
    public function mail($id)
    {
        DB::table('enrolls')->where('id_no', $id)
            ->where('confirm', 0)
            ->update(['confirm' => 1]);

        DB::table('course_enroll')->where('student_id', $id)
            ->where('confirm', 0)
            ->update(['confirm' => 1]);

        // Retrieve student information for mail
        $user = DB::table('users')->where('id_no','=',$id)->first();

        $email_address = $user->email;
        $first_name = $user->first_name;
        $last_name = $user->last_name;
        $student_id = $user->id_no;

        $name = $first_name.' '.$last_name;

        $pstu_email = 'emailfordeveloper578@gmal.com';

        // data to be showed to email
        $data = array(
            'student_email' => $email_address,
            'pstu_email' => $pstu_email,
            'subject' => 'PSTU Enrollment',
            'pstu_admin' => 'PSTU Administration',
            'name' => $name,
            'student_id' => $student_id
        );

        // mail to student
        Mail::send('admin.email',$data,function($message) use($data){
            $message->from($data['pstu_email']);
            $message->to($data['student_email']);
            $message->subject($data['subject']);
        });

        session()->flash('success', 'Email has been Successfully send');

        return back();
    }






    public function unconfirmEnroll($id)
    {
        DB::table('enrolls')->where('id_no', $id)
            ->where('confirm', 1)
            ->update(['confirm' => 0]);

        DB::table('course_enroll')->where('student_id', $id)
            ->where('confirm', 1)
            ->update(['confirm' => 0]);

        // Retrieve student information for mail
        $user = DB::table('users')->where('id_no','=',$id)->first();

        $email_address = $user->email;
        $first_name = $user->first_name;
        $last_name = $user->last_name;
        $student_id = $user->id_no;

        $name = $first_name.' '.$last_name;

        $pstu_email = 'emailfordeveloper578@gmal.com';

        // data to be showed to email
        $data = array(
            'student_email' => $email_address,
            'pstu_email' => $pstu_email,
            'subject' => 'PSTU Enrollment',
            'pstu_admin' => 'PSTU Administration',
            'name' => $name,
            'student_id' => $student_id,
            'faculty' => Auth::User()->admin_faculty
        );

        // mail to student
        Mail::send('email.unconfirmEnroll',$data,function($message) use($data){
            $message->from($data['pstu_email']);
            $message->to($data['student_email']);
            $message->subject($data['subject']);
        });

        session()->flash('success', 'Email has been Successfully send');

        return back();
    }







    public function searchUnconfirm(Request $request){
        $level = $request->level;
        $semester = $request->semester;
        $search = $request->search;
        $year = date('Y');

        // Retrieve admin faculty_name
        $admin_faculty_name = Auth::User()->admin_faculty;

        // Retrieve required level & semester enrolled list(Only Admin's Faculty)
        $enrolls = DB::table('enrolls')->where('faculty', $admin_faculty_name)
                                ->where('level', $level)
                                ->where('semester', $semester)
                                ->where('confirm', 0)
                                ->where('enroll_year', $year)
                                ->where('id_no', $search)
                                ->get();

        $confirm = 0;
        return view('admin.enrolllist',compact('enrolls','level','semester','confirm'));
    }






    public function searchCompleted(Request $request){
        $level = $request->level;
        $semester = $request->semester;
        $search = $request->search;
        $year = date('Y');

        // Retrieve admin faculty_name
        $admin_faculty_name = Auth::User()->admin_faculty;

        // Retrieve required level & semester enrolled list(Only Admin's Faculty)
        $enrolls = DB::table('enrolls')->where('faculty', $admin_faculty_name)
                                ->where('level', $level)
                                ->where('semester', $semester)
                                ->where('confirm', 1)
                                ->where('enroll_year', $year)
                                ->where('id_no', $search)
                                ->get();

        $confirm = 1;
        return view('admin.enrolllist',compact('enrolls','level','semester','confirm'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Faculty;
use Hash;
use Mail;
use App\Admin;
use App\Mail\verifyEmail;
use App\Hall;

class AdminStudentController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }



    // Student List For Admin(Only his/her faculty)
    public function index($session)
    {
      $admin_id = Auth::User()->id;

      // Retrieve admin faculty_name
      if(Auth::User()->admin_type == "Hall"){
         $admin_hall = Hall::where('hall_name', Auth::User()->admin_faculty)
             ->first();
         $admin_hall_id = $admin_hall->id;

         // All Student Information
         $students = User::where('hall_id', $admin_hall_id)
                 ->where('session', $session)
                 ->where('status', 1)
                 ->get();

         return view('admin.student_list',compact('students','session'));
      }
      else if(Auth::User()->admin_type == "Faculty"){
        $admin_faculty_name = Auth::User()->admin_faculty;
        // Retrieve admin faculty_id
        $faculty = Faculty::where('faculty_name', $admin_faculty_name)
             ->first();

        // All Student Information
        $students = User::where('faculty_id', $faculty->faculty_id)
             ->where('session', $session)
             ->where('status', 1)
             ->get();

        return view('admin.student_list',compact('students','session'));
      }
      else{
        // All Student Information
        $students = User::where('session', $session)
                ->where('status', 1)
                ->get();

        return view('admin.student_list')->withStudents($students);
      }
    }




    public function studentDetails($id){
        $student = User::where('id_no', $id)->first();
        return view('admin.studentDetails',compact('student'));
    }




    public function searchStudent(Request $request)
    {
      $admin_id = Auth::User()->id;
      $session = $request->session;
      $student_id = $request->student_id;

      // Retrieve admin faculty_name
      if(Auth::User()->admin_type == "Hall"){
         $admin_hall = Hall::where('hall_name', Auth::User()->admin_faculty)
             ->first();
         $admin_hall_id = $admin_hall->id;

         // All Student Information
         $students = User::where('hall_id', $admin_hall_id)
                 ->where('session', $session)
                 ->where('status', 1)
                 ->where('id_no', $student_id)
                 ->get();

         return view('admin.student_list',compact('students','session'));
      }
      else if(Auth::User()->admin_type == "Faculty"){
        $admin_faculty_name = Auth::User()->admin_faculty;
        // Retrieve admin faculty_id
        $faculty = Faculty::where('faculty_name', $admin_faculty_name)
             ->first();

        // All Student Information
        $students = User::where('faculty_id', $faculty->faculty_id)
             ->where('session', $session)
             ->where('status', 1)
             ->where('id_no', $student_id)
             ->get();

        return view('admin.student_list',compact('students','session'));
      }
      else{
        // All Student Information
        $students = User::where('session', $session)
                ->where('status', 1)
                ->where('id_no', $student_id)
                ->get();

        return view('admin.student_list')->withStudents($students);
      }
    }




    // Delete Student Information
    public function destroy($id)
    {
      DB::table('users')->where('id','=',$id)->delete();
      return redirect()->route('admin.studentlist');
    }
}

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
use App\Session;
use App\Hall;

class StudentController extends Controller
{

    public function __construct(){
        $this->middleware('auth',['except' => ['create','store','accountVerified']]);
    }




    // student profile view
    public function index()
    {
        $student_id = Auth::User()->id_no;
        $student = User::where('id_no', $student_id)
                   ->where('status', 1)
                   ->first();

        $faculty = Faculty::where('faculty_id', Auth::User()->faculty_id)
                    ->first();

        return view('user-view.profile')->withStudent($student)->withFaculty($faculty);
    }





    // register form for student
    public function create()
    {
        $faculties = Faculty::all();
        $sessions = Session::all();
        $halls = Hall::all();

        return view('auth.register')->withFaculties($faculties)->withsessions($sessions)->withHalls($halls);
    }

    




    // store unconfirm student
    public function store(Request $request)
    {
        $this->validate($request,array(
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'faculty_id' => 'required|string|max:255',
            'reg_no' => 'required|string|max:255',
            'student_id' => 'required|string|max:255',
            'session' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'full_address' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'hall_id' => 'required|integer|max:2',
            'hall_allot_id' => 'required|integer|min:4'
            ));

        // get student information from the from
        $student = new User();

        $student->first_name   =  $request->first_name;
        $student->last_name    =  $request->last_name;
        $student->father_name    =  $request->father_name;
        $student->mother_name    =  $request->mother_name;
        $student->email        =  $request->email;
        $student->faculty_id   =  $request->faculty_id;
        $student->registration_no   =  $request->reg_no;
        $student->id_no        =  $request->student_id;
        $student->hall_id        =  $request->hall_id;
        $student->hall_alot_id        =  $request->hall_allot_id;
        $student->session      =  $request->session;
        $student->city         =  $request->city;
        $student->full_address   =  $request->full_address;
        $student->password     =  bcrypt($request->password);
        $student->verify_token = Str::random(40);
        $student->status = 0;

        $student_email = $student->email;
        $verify_token = $student->verify_token;

        // store to student database
        $student->save();

        // $pstu_email = 'emailfordeveloper578@gmal.com';

        // $data = array(
        //     'student_email' => $student_email,
        //     'pstu_email' => $pstu_email,
        //     'subject' => 'Account Activation',
        //     'verify_token' => $verify_token
        // );

        // Mail::send('email.sendView',$data,function($message) use($data){
        //     $message->from($data['pstu_email']);
        //     $message->to($data['student_email']);
        //     $message->subject($data['subject']);
        // });

        return view('email.verifyStudent');
    }





    // verify student
    public function accountVerified($email,$verify_token){

      DB::table('users')
            ->where('email', $email)
            ->where('verify_token', $verify_token)
            ->update(['status' => 1]);

      return redirect()->route('login');

    }

    // public function sendEmail($thisUser){
    //   Mail::to($thisUser['email'])->send(new verifyEmail($thisUser));
    // }
    //
    // public function verifyEmail(){
    //   return view('email.verifyStudent');
    // }
    //
    // public function sendEmailDone($email,$verifyToken){
    //   dd($email);
    // }

    




    // editform for update student profile
    public function edit()
    {
        $student_id = Auth::User()->id;
        $student   = User::find($student_id);
        $faculties = Faculty::all();

        return view('user-view.student_edit')->withStudent($student)->withFaculties($faculties);
    }

    





    // update student profile
    public function update(Request $request)
    {
        $std_id = Auth::User()->id;
        $student = User::find($std_id);

        $this->validate($request, array(
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$student->id,
            'faculty_id' => 'required|string|max:255',
            'reg_no' => 'required|string|max:255',
            'student_id' => 'required|string|max:255|unique:users,id_no,'.$student->id,
            'session' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'full_address' => 'required|string|max:255'
            ));

        $student->first_name   =  $request->first_name;
        $student->last_name    =  $request->last_name;
        $student->father_name    =  $request->father_name;
        $student->mother_name    =  $request->mother_name;
        $student->email        =  $request->email;
        $student->faculty_id   =  $request->faculty_id;
        $student->registration_no   =  $request->reg_no;
        $student->id_no        =  $request->student_id;
        $student->session      =  $request->session;
        $student->city         =  $request->city;
        $student->full_address   =  $request->full_address;

        $student->save();

        session()->flash('success', 'Information Updated Successfully');
        return redirect()->route('user.profile');
    }

   




    // change password form
    public function changePasswordForm()
    {
      return view('user-view.password-change');
    }



    

    // update password
    public function changePassword(Request $request)
    {
      $this->validate($request, array(
        'current_password' => 'required|min:6',
        'new_password' => 'required|string|min:6',
        'password_confirmation' => 'required|string|min:6'
          ));

      if($request->new_password != $request->password_confirmation){

        session()->flash('not_match',"Confirm Password Does Not match With New Password");
        return back();
      }
      else{
      $current_password = $request->current_password;
      $user_id = Auth::User()->id_no;
      $con = Hash::check($current_password,Auth::User()->password);

        if($con){
        $new_password = bcrypt($request->new_password);
        DB::table('users')
              ->where('id_no', $user_id)
              ->update(['password' => $new_password]);

        session()->flash('success',"Password Changed Successfully");
        return back();
      }
      session()->flash('alert',"Wrong Old Password");
      return back();
      }
    }
}

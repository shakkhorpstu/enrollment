<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\HallStudent;
use Mail;
use Session;
use Auth;

class HallStudentController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }





    public function unpaid($id)
    {
        $admin_hall_name = Auth::User()->admin_faculty;
        $hall = DB::table('halls')
            ->where('hall_name', $admin_hall_name)
            ->first();

        $faculty = DB::table('faculties')
            ->where('faculty_url', $id)
            ->first();

        $hallsstudentss = DB::table('hall_student')
            ->where('hall_id', $hall->id)
            ->where('faculty_id', $faculty->faculty_id)
            ->where('payment_status', 0)
            ->get();

        $confirm = 0;
        $faculty_id = $faculty->faculty_id;
        return view('admin.hallStudentInformation',compact('hallsstudentss','confirm','faculty_id'));
    }






    public function paid($id)
    {
        $admin_hall_name = Auth::User()->admin_faculty;
        $hall = DB::table('halls')
            ->where('hall_name', $admin_hall_name)
            ->first();

        $faculty = DB::table('faculties')
            ->where('faculty_url', $id)
            ->first();

        $hallsstudentss = DB::table('hall_student')
            ->where('hall_id', $hall->id)
            ->where('faculty_id', $faculty->faculty_id)
            ->where('payment_status', 1)
            ->get();

        $confirm = 1;
        $faculty_id = $faculty->faculty_id;
        return view('admin.hallStudentInformation',compact('hallsstudentss','confirm','faculty_id'));
    }






    public function paidHall($id){
      DB::table('hall_student')
            ->where('id_no', $id)
            ->update(['payment_status' => 1]);

      DB::table('enrolls')
            ->where('id_no', $id)
            ->update(['hall_pay_status' => 1]);

      $student_info = DB::table('users')
            ->where('id_no', $id)->first();

      $first_name = $student_info->first_name;
      $last_name = $student_info->last_name;
      $email_address = $student_info->email;
      $student_id = $id;
      $allot_id = $student_info->hall_alot_id;
      $hall_id = $student_info->hall_id;
      $name = $first_name.' '.$last_name;

      $hall = DB::table('halls')
            ->where('id', $hall_id)->first();
      $pstu_email = 'emailfordeveloper578@gmal.com';

        // data to be showed to email
        $data = array(
            'student_email' => $email_address,
            'pstu_email' => $pstu_email,
            'subject' => 'PSTU Enrollment',
            'pstu_admin' => $hall->hall_name,
            'name' => $name,
            'student_id' => $student_id,
            'allot_id' => $allot_id,
            'hall_name' => $hall->hall_name
        );

        // mail to student
        Mail::send('email.hallEmail',$data,function($message) use($data){
            $message->from($data['pstu_email']);
            $message->to($data['student_email']);
            $message->subject($data['subject']);
        });

        session()->flash('success', 'Email has been Successfully send');

      return back();
    }





    public function unPaidHall($id){
      DB::table('hall_student')
            ->where('id_no', $id)
            ->update(['payment_status' => 0]);

      DB::table('enrolls')
            ->where('id_no', $id)
            ->update(['hall_pay_status' => 0]);

      $student_info = DB::table('users')
            ->where('id_no', $id)->first();

      $first_name = $student_info->first_name;
      $last_name = $student_info->last_name;
      $email_address = $student_info->email;
      $student_id = $id;
      $allot_id = $student_info->hall_alot_id;
      $hall_id = $student_info->hall_id;
      $name = $first_name.' '.$last_name;

      $hall = DB::table('halls')
            ->where('id', $hall_id)->first();
      $pstu_email = 'emailfordeveloper578@gmal.com';

        // data to be showed to email
        $data = array(
            'student_email' => $email_address,
            'pstu_email' => $pstu_email,
            'subject' => 'PSTU Enrollment',
            'pstu_admin' => $hall->hall_name,
            'name' => $name,
            'student_id' => $student_id,
            'allot_id' => $allot_id,
            'hall_name' => $hall->hall_name
        );

        // mail to student
        Mail::send('email.unconfirmHall',$data,function($message) use($data){
            $message->from($data['pstu_email']);
            $message->to($data['student_email']);
            $message->subject($data['subject']);
        });

        session()->flash('success', 'Email has been Successfully send');

      return back();
    }





    public function searchUnconfirm(Request $request){
        $hall_name = Auth::User()->admin_faculty;
        $faculty_id = $request->faculty_id;
        $student_id = $request->search;

        $hall = DB::table('halls')
            ->where('hall_name', $hall_name)
            ->first();

        $hallsstudentss = DB::table('hall_student')
            ->where('payment_status', 0)
            ->where('hall_id', $hall->id)
            ->where('faculty_id', $faculty_id)
            ->where('id_no', $student_id)
            ->get();

        $confirm = 0;
        return view('admin.hallStudentInformation',compact('hallsstudentss','confirm','faculty_id'));
    }





    public function searchConfirm(Request $request){
        $hall_name = Auth::User()->admin_faculty;
        $faculty_id = $request->faculty_id;
        $student_id = $request->search;

        $hall = DB::table('halls')
            ->where('hall_name', $hall_name)
            ->first();

        $hallsstudentss = DB::table('hall_student')
            ->where('payment_status', 1)
            ->where('hall_id', $hall->id)
            ->where('faculty_id', $faculty_id)
            ->where('id_no', $student_id)
            ->get();

        $confirm = 1;
        return view('admin.hallStudentInformation',compact('hallsstudentss','confirm','faculty_id'));
    }

    


    
    public function destroy($id)
    {
      DB::table('hall_student')->where('id_no','=',$id)->delete();
      return back();
    }
}

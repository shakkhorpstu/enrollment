<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use Hash;

class CoAdminController extends Controller
{

    public function __construct(){
        $this->middleware('auth:admin');
    }



    public function index()
    {
        $admins = Admin::all();
        return view('admin.admin',compact('admins'));
    }



    public function store(Request $request)
    {
        $this->validate($request,[
            'admin_name' => 'required',
            'admin_type' => 'required',
            'admin_section' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $admin = new Admin();

        $admin->name = $request->admin_name;
        $admin->admin_type = $request->admin_type;
        $admin->admin_faculty = $request->admin_section;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);

        $admin->save();

        return back();
    }



    // change password form
    public function changePasswordForm()
    {
      return view('admin.changePassword');
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
      $user_id = Auth::User()->id;
      $con = Hash::check($current_password,Auth::User()->password);

        if($con){
        $new_password = bcrypt($request->new_password);
        DB::table('admins')
              ->where('id', $user_id)
              ->update(['password' => $new_password]);

        session()->flash('success',"Password Changed Successfully");
        return back();
      }
      session()->flash('alert',"Wrong Old Password");
      return back();
      }
    }



    public function destroy($id)
    {
        DB::table('admins')->where('id','=',$id)->delete();
        return redirect()->route('admin.admin');
    }
}

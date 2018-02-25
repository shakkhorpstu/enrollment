<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Session;

class SessionController extends Controller
{

    public function __construct(){
        $this->middleware('auth:admin');
    }






    public function index()
    {
        $sessions = Session::all();
        return view('admin.sessionList',compact('sessions'));
    }





    public function store(Request $request)
    {
        $this->validate($request,array(
          'session' => 'required|string|max:255'
          ));
        $session_name = $request->session;
        
        $session = new Session();
        $session->session = $session_name;
        $session->save();

        return redirect()->route('admin.session');
    }

    




    public function edit($id)
    {
        $session = Session::find($id);
        return view('admin.sessionEdit',compact('session'));
    }

    




    public function update(Request $request, $id)
    {
        $sessions = Session::find($id);

        $this->validate($request,[
            'session' => 'required|max:255'
        ]);

        $sessions->session = $request->session;

        $sessions->save();

        return redirect()->route('admin.session');
    }





    public function destroy($id)
    {
        DB::table('sessions')->where('id','=',$id)->delete();
        return redirect()->route('admin.session');
    }
}

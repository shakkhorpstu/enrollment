<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Hall;

class HallController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }
    



    public function index()
    {
        $halls = Hall::all();
        return view('admin.hallList')->withHalls($halls);
    }



    

    public function store(Request $request)
    {
      $this->validate($request,array(
          'hall_name' => 'required|string|max:255'
          ));
        $hall_name = $request->hall_name;

        $hall = new hall();
        $hall->hall_name = $hall_name;
        $hall->save();

        return back();
    }

   



    public function edit($id)
    {
        $hall = Hall::find($id);
        return view('admin.hallEdit',compact('hall'));
    }

   




    public function update(Request $request, $id)
    {
        $hall = Hall::find($id);

        $this->validate($request,[
            'hall_name' => 'required|max:255'
        ]);

        $hall->hall_name = $request->hall_name;

        $hall->save();

        return redirect()->route('admin.hallList');
    }





    public function destroy($id)
    {
        DB::table('halls')->where('id','=',$id)->delete();
        return redirect()->route('admin.hallList');
    }
}

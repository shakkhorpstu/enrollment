<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faculty;
use Illuminate\Support\Facades\DB;

class FacultyController extends Controller
{

    public function __construct(){
        $this->middleware('auth:admin');
    }





    // Retrieve all faculties
    public function index()
    {
        $faculties = Faculty::all();
        return view('admin.faculties')->withFaculties($faculties);
    }





    public function store(Request $request)
    {
        $this->validate($request,array(
                'faculty_name' => 'required|max:255',
                'faculty_id'   => 'required|min:1|max:2|unique:faculties'
            ));

        $faculty_url_lower_case = strtolower($request->faculty_name);
        $faculty_url = str_replace(' ', '', $faculty_url_lower_case);

        // store to database
        $faculty = new Faculty();

        $faculty->faculty_name = $request->faculty_name;
        $faculty->faculty_id   = $request->faculty_id;
        $faculty->faculty_url  = $faculty_url;

        $faculty->save();

        return redirect()->route('admin.faculties');
    }





    // Edit form for faculty information
    public function edit($id)
    {
        $faculty = Faculty::where('faculty_id',$id)->first();
        return view('admin.faculty_edit')->withFaculty($faculty);
    }

   





    // Update faculty information
    public function update(Request $request, $id)
    {
        $faculty = Faculty::find($id);

        $this->validate($request,[
            'faculty_name' => 'required|max:255',
            'faculty_id'   => 'required|min:1|max:2|unique:faculties,faculty_id,'.$faculty->faculty_id,
        ]);

        $faculty->faculty_name = $request->faculty_name;
        $faculty->faculty_id   = $request->faculty_id;

        $faculty->save();

        return redirect()->route('admin.faculties');
    }

    

    

    // delete faculty imformation
    public function destroy($id)
    {
        DB::table('faculties')->where('faculty_id','=',$id)->delete();
        return redirect()->route('admin.faculties');
    }
}

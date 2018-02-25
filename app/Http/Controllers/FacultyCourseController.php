<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Course;

class FacultyCourseController extends Controller
{

    public function __construct(){
        $this->middleware('auth:admin',['except' => ['semester','index']]);
    }
   



    // Only logged in admin can access his/her faculties course

    // retrieve semester list for student
    public function semester($id)
    {
        $ids = $id;
        return view('user-view.semesterList')->withIds($ids);
    }





    // retrieve course list for individual semester & faculty
    public function index($faculty,$level,$semester)
    {
        $level_split = explode("-",$level);
        $level = $level_split[1];
        $semester_split = explode("-",$semester);
        $semester = $semester_split[1];

        // retrieve faculty information
        $faculty = DB::table('faculties')
        ->where('faculty_url', $faculty)
        ->first();
        // retirieve course for requested semester & faculty
        $courses = DB::table('courses')
        ->where('faculty_name', $faculty->faculty_id)
        ->where('level',$level)
        ->where('semester', $semester)
        ->get();

        return view('user-view.courseList')->withCourses($courses);
    }





    public function semsterCourse($level,$semester){
      $admin_faculty = Auth::User()->admin_faculty;

      $faculty = DB::table('faculties')
      ->where('faculty_name', $admin_faculty)
      ->first();

      $level_split = explode("-",$level);
      $find_level = $level_split[1];

      $semester_split = explode("-",$semester);
      $find_semester = $semester_split[1];

      // retirieve course for requested level & semester & faculty
      $courses = DB::table('courses')
      ->where('faculty_name', $faculty->faculty_id)
      ->where('level', $find_level)
      ->where('semester', $find_semester)
      ->get();

      $level = $find_level;
      $semester = $find_semester;
      return view('admin.courseList',compact('courses','level','semester'));
    }

    



    public function create()
    {
      return view('admin.addCourse');
    }





    // save course for admin faculty
    public function store(Request $request)
    {
      $admin_faculty = Auth::User()->admin_faculty;

      $faculty = DB::table('faculties')
      ->where('faculty_name',$admin_faculty)
      ->first();

      $faculty_id = $faculty->faculty_id;

      // Semester Handling Split
      $course_id = explode("-",$request->course_code);
      $semester_id = $course_id[1];
      $semester_split = str_split($semester_id, 1);
      $level_check = $semester_split[0];
      $semester_check = $semester_split[1];

      if($level_check == 1){
        if($semester_check == 1){
          $semester = 1;
        }
        else{
          $semester = 2;
        }
      }
      else if($level_check == 2){
        if($semester_check == 1){
          $semester = 1;
        }
        else{
          $semester = 2;
        }
      }
      else if($level_check == 3){
        if($semester_check == 1){
          $semester = 1;
        }
        else{
          $semester = 2;
        }
      }
      else if($level_check == 4){
        if($semester_check == 1){
          $semester = 1;
        }
        else{
          $semester = 2;
        }
      }
      else if($level_check == 5){
          $semester = 9;
      }

      $course = new Course();

      $course->faculty_name = $faculty_id;
      $course->course_id = $request->course_code;
      $course->course_title = $request->course_title;
      $course->credit = $request->course_credit;
      $course->level = $level_check;
      $course->semester = $semester;

      $course->save();

      session()->flash('success','Course Details Added Successfully');
      return redirect()->route('admin.addCourse');
    }




   

    // edit form for course(admin_faculty)
    public function edit($course_title)
    {
        $course = DB::table('courses')
        ->where('course_title',$course_title)
        ->first();

        return view('admin.editCourse')->withCourse($course);
    }

    





    // update course information for admin_faculty
    public function update(Request $request, $id)
    {
        $course = Course::find($id);

        // Semester Handling Split
        $course_id = explode("-",$request->course_id);
        $semester_id = $course_id[1];
        $semester_split = str_split($semester_id, 1);
        $level_check = $semester_split[0];
        $semester_check = $semester_split[1];

        if($level_check == 1){
          if($semester_check == 1){
            $semester = 1;
          }
          else{
            $semester = 2;
          }
        }
        else if($level_check == 2){
          if($semester_check == 1){
            $semester = 1;
          }
          else{
            $semester = 2;
          }
        }
        else if($level_check == 3){
          if($semester_check == 1){
            $semester = 1;
          }
          else{
            $semester = 2;
          }
        }
        else if($level_check == 4){
          if($semester_check == 1){
            $semester = 1;
          }
          else{
            $semester = 2;
          }
        }
        else if($level_check == 5){
            $semester = 9;
        }

        $course->course_id = $request->course_id;
        $course->course_title = $request->course_title;
        $course->semester = $request->semester;
        $course->credit = $request->credit;
        $course->level = $level_check;
        $course->semester = $semester;

        $course->save();

        session()->flash('success','Updated Successfully');
        return back();
    }





    public function searchCourse(Request $request){
      $admin_faculty = Auth::User()->admin_faculty;
      $course_code = $request->search;
      $level = $request->level;
      $semester = $request->semester;

      $faculty = DB::table('faculties')
      ->where('faculty_name', $admin_faculty)
      ->first();

      // retirieve course for requested level & semester & faculty
      $courses = DB::table('courses')
      ->where('faculty_name', $faculty->faculty_id)
      ->where('level', $level)
      ->where('semester', $semester)
      ->where('course_id', $course_code)
      ->get();
      
      return view('admin.courseList',compact('courses','level','semester'));
    }

    




    // delete course
    public function destroy($course_title)
    {
        DB::table('courses')->where('course_title','=',$course_title)->delete();

        session()->flash('delete','Course Information Deleted Successfully');
        return back();
    }
}

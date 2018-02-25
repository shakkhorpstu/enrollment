<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faculty;
use App\UserFaculty;

class UserFacultyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }





    // faculty list for student
    public function index()
    {
        $faculties = Faculty::all();
        return view('user-view.user_faculties')->withFaculties($faculties);
    }

}

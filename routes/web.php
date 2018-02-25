<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('/home', 'HomeController@index')->name('home');
// First Enrollment Form
Route::get('/enrollform', 'EnrollController@semesterInfo')->name('enrollform');
// Second Form With FI Or Not
Route::post('/enrollform/repeatform', 'EnrollController@fiInfo')->name('enrollform.repeat');
// Final Information Check
Route::post('/submit/enrollform/details', 'EnrollController@finalInfo')->name('enrollform.details');
// Add To Database
Route::post('/submit/enrollform', 'EnrollController@store')->name('submit.enrollform');
// Faculty List
Route::get('/faculties', 'UserFacultyController@index')->name('user.faculties');
// Faculty Wise Semester List
Route::get('/faculties/semester/{id}', 'FacultyCourseController@semester')->name('user.faculties.semester');
// Semester Wise Course List
Route::get('/faculties/{id}/{level}/{semester}', 'FacultyCourseController@index')->name('user.faculties.courses');

// Student
// Student Registration Form
Route::get('/register', 'StudentController@create')->name('studentform');
// Verify The Student
Route::get('accountverified/{email}/{verify_token}', 'StudentController@accountVerified')->name('accountVerified');
// Add Student
Route::post('/register', 'StudentController@store')->name('submit.student');
// Student Profile
Route::get('/profile', 'StudentController@index')->name('user.profile');
// Edit Student Profile
Route::get('/students/editprofile', 'StudentController@edit')->name('editProfile');
// Update Student List
Route::post('/students/editprofile', 'StudentController@update')->name('updateStudent');
// Change Password Form
Route::get('/change-password', 'StudentController@changePasswordForm')->name('user.changePassword');
// Store New Password 
Route::post('/change-password', 'StudentController@changePassword')->name('submit.changePassword');


// Route::get('/verifyemail', 'StudentController@verifyEmail')->name('verifyEmail');
// Route::get('/verify/{email}/{verifyToken}', 'StudentController@sendEmailDone')->name('sendEmailDone');
// Route::get('/faculties/{id/semester}', 'FacultyCourseController@index')->name('user.faculties.courses');


Route::prefix('/admin')->group(function(){
  // Admin Authentication
	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@adminLogin')->name('admin.login.submit');
	Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

  // Admin Home
	Route::get('/', 'AdminController@index')->name('admin.home');

  // CoAdmin
	Route::get('/manage-admin', 'CoAdminController@index')->name('admin.admin');
	Route::post('/store', 'CoAdminController@store')->name('admin.admin.store');
	Route::get('/change-password', 'CoAdminController@changePasswordForm')->name('admin.admin.changePassword');
	Route::post('/change-password', 'CoAdminController@changePassword')->name('admin.submit.changePassword');
	Route::delete('/{id}', 'CoAdminController@destroy')->name('admin.admin.delete');

  // Faculties
  Route::get('/faculties', 'FacultyController@index')->name('admin.faculties');
	Route::post('/faculties/store', 'FacultyController@store')->name('admin.faculties.store');
	Route::get('/faculties/{id}/edit', 'FacultyController@edit')->name('admin.faculties.edit');
	Route::put('/faculties/{faculty_id}', 'FacultyController@update')->name('admin.faculties.update');
	Route::delete('/faculties/{id}', 'FacultyController@destroy')->name('admin.faculties.delete');

  // Student List
	Route::get('/studentlist/{session}', 'AdminStudentController@index')->name('admin.studentlist');
	Route::get('/details/{id}', 'AdminStudentController@studentDetails')->name('admin.student.details');
	Route::delete('/students/{id}', 'AdminStudentController@destroy')->name('admin.students.delete');

  // Enroll Routes
  // Confirmation
	Route::post('/enroll/mail/{id}', 'EnrollDetailsController@mail')->name('admin.enroll.mail');
  // Unconfirm The Enroll
	Route::post('/enroll/completed/{id}', 'EnrollDetailsController@unconfirmEnroll')->name('admin.enroll.unconfirm');
  // Incompleted Repeat List
  Route::post('/enroll/repeat/{id}', 'EnrollDetailsController@repeat')->name('admin.enroll.repeat');
  // Completed Repeat List
  Route::post('/enroll/completed/repeat/{id}', 'EnrollDetailsController@completedRepeat')->name('admin.enroll.completedRepeat');
  // Enroll Delete
	Route::delete('/enroll/{id}', 'EnrollDetailsController@destroy')->name('admin.enroll.delete');
  // Get All Unconfirm Enroll
	Route::get('/enroll/{level}/{semester}', 'EnrollDetailsController@facultyenrollment')->name('admin.semester.enroll');
  // Uncompleted Enroll List
	Route::get('/enroll/completed/{level}/{semester}', 'EnrollDetailsController@completedEnrollList')->name('admin.semester.completeEnroll');

  // Course
  Route::get('/addcourse', 'FacultyCourseController@create')->name('admin.addCourse');
  Route::get('/course/{level}/{semester}', 'FacultyCourseController@semsterCourse')->name('admin.semester.course');
  Route::post('/addcourse', 'FacultyCourseController@store')->name('admin.storeCourse');
  Route::get('/course/{course_title}', 'FacultyCourseController@edit')->name('admin.course.edit');
	Route::put('/course/{course_title}', 'FacultyCourseController@update')->name('admin.course.update');
	Route::delete('/course/{course_title}', 'FacultyCourseController@destroy')->name('admin.course.delete');

  // Hall
  Route::get('/halllist', 'HallController@index')->name('admin.hallList');
  Route::post('/hall', 'HallController@store')->name('admin.addHall');
  Route::get('/hall/{id}/edit', 'HallController@edit')->name('admin.hall.edit');
	Route::put('/hall/{id}', 'HallController@update')->name('admin.hall.update');
  Route::delete('/hall/{id}', 'HallController@destroy')->name('admin.hall.delete');

  // Session
  Route::get('/session', 'SessionController@index')->name('admin.session');
  Route::post('/session', 'SessionController@store')->name('admin.addSession');
  Route::get('/session/{id}/edit', 'SessionController@edit')->name('admin.session.edit');
	Route::put('/session/{id}', 'SessionController@update')->name('admin.session.update');
  Route::delete('/session/{id}', 'SessionController@destroy')->name('admin.session.delete');

  // Hall Payment
  // Get All unpaid Student
  Route::get('/hall/{id}', 'HallStudentController@unpaid')->name('admin.hall.unpaid');
  // Get All paid Student
  Route::get('/hall/paid/{id}', 'HallStudentController@paid')->name('admin.hall.paid');
  // Confirm Paid The Student
  Route::get('/hallpaid/{id}', 'HallStudentController@paidHall')->name('admin.hallPaid');
  // Unconfirm The Payment
  Route::get('/hallunpaid/{id}', 'HallStudentController@unPaidHall')->name('admin.hallUnpaid');
  // Delete
  Route::delete('/hallstudent/{id}', 'HallStudentController@destroy')->name('admin.hallstudent.delete');

  //search
  Route::post('/enroll/uncompleted/search', 'EnrollDetailsController@searchUnconfirm')->name('admin.search.uncompleteEnroll');
  Route::post('/enroll/search/completed', 'EnrollDetailsController@searchCompleted')->name('admin.search.completeEnroll');
  Route::post('/student/search', 'AdminStudentController@searchStudent')->name('admin.search.studentList');
  Route::post('/hallpay/unconfirm/search', 'HallStudentController@searchUnconfirm')->name('admin.search.unconfirmHall');
  Route::post('/hallpay/confirm/search', 'HallStudentController@searchConfirm')->name('admin.search.confirmHall');
  Route::post('/course/search', 'FacultyCourseController@searchCourse')->name('admin.search.course');
});

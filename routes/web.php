<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Setting;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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

/** for side bar menu active */
function set_active( $route ) {
    if( is_array( $route ) ){
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

// Show welcome page at root
Route::get('/', function () {
    return view('welcome');
});

// Simple redirect to login page
Route::get('/apply', function () {
    return redirect('/login');
})->name('apply');

// Authentication routes
Route::group(['namespace' => 'App\Http\Controllers\Auth'],function()
{
    // Login routes
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
        Route::get('/logout', 'logout')->name('logout');
    });

    // Register routes
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/register','storeUser')->name('register');    
    });
});

// Password Reset Routes
Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// All authenticated routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/home', function () {
        return view('dashboard.home');
    })->name('home');

    // -------------------------- main dashboard ----------------------//
    Route::controller(HomeController::class)->group(function () {
        Route::get('user/profile/page', 'userProfile')->name('user/profile/page');
        Route::get('teacher/dashboard', 'teacherDashboardIndex')->name('teacher/dashboard');
        Route::get('student/dashboard', 'studentDashboardIndex')->name('student/dashboard');
    });

    // ----------------------------- user controller ---------------------//
    Route::controller(UserManagementController::class)->group(function () {
        Route::get('list/users', 'index')->name('list/users');
        Route::post('change/password', 'changePassword')->name('change/password');
        Route::get('view/user/edit/{id}', 'userView');
        Route::post('user/update', 'userUpdate')->name('user/update');
        Route::post('user/delete', 'userDelete')->name('user/delete');
        Route::get('get-users-data', 'getUsersData')->name('get-users-data'); /** get all data users */
    });

    // ------------------------ setting -------------------------------//
    Route::controller(Setting::class)->group(function () {
        Route::get('setting/page', 'index')->name('setting/page');
        Route::get('security/encapsulation', 'encapsulation')->name('encapsulation');
        Route::post('toggle-encryption', 'toggleEncryption')->name('setting.toggle.encryption');
    });

    // ------------------------ student -------------------------------//
    Route::controller(StudentController::class)->group(function () {
        Route::get('student/list', 'student')->name('student/list'); // list student
        Route::get('student/grid', 'studentGrid')->name('student/grid'); // grid student
        Route::get('student/add/page', 'studentAdd')->name('student/add/page'); // page student
        Route::post('student/add/save', 'studentSave')->name('student/add/save'); // save record student
        Route::get('student/edit/{id}', 'studentEdit'); // view for edit
        Route::post('student/update', 'studentUpdate')->name('student/update'); // update record student
        Route::post('student/delete', 'studentDelete')->name('student/delete'); // delete record student
        Route::get('student/profile/{id}', 'studentProfile'); // profile student
    });

    // ------------------------ teacher -------------------------------//
    Route::controller(TeacherController::class)->group(function () {
        Route::get('teacher/add/page', 'teacherAdd')->name('teacher/add/page'); // page teacher
        Route::get('teacher/list/page', 'teacherList')->name('teacher/list/page'); // page teacher
        Route::get('teacher/grid/page', 'teacherGrid')->name('teacher/grid/page'); // page grid teacher
        Route::post('teacher/save', 'saveRecord')->name('teacher/save'); // save record
        Route::get('teacher/edit/{user_id}', 'editRecord'); // view teacher record
        Route::post('teacher/update', 'updateRecordTeacher')->name('teacher/update'); // update record
        Route::post('teacher/delete', 'teacherDelete')->name('teacher/delete'); // delete record teacher
    });

    // ----------------------- department -----------------------------//
    Route::controller(DepartmentController::class)->group(function () {
        Route::get('department/list/page', 'departmentList')->name('department/list/page'); // department/list/page
        Route::get('department/add/page', 'indexDepartment')->name('department/add/page'); // page add department
        Route::get('department/edit/{department_id}', 'editDepartment'); // page add department
        Route::post('department/save', 'saveRecord')->name('department/save'); // department/save
        Route::post('department/update', 'updateRecord')->name('department/update'); // department/update
        Route::post('department/delete', 'deleteRecord')->name('department/delete'); // department/delete
        Route::get('get-data-list', 'getDataList')->name('get-data-list'); // get data list
    });

    // ----------------------- subject -----------------------------//
    Route::controller(SubjectController::class)->group(function () {
        Route::get('subject/list/page', 'subjectList')->name('subject/list/page'); // subject/list/page
        Route::get('subject/add/page', 'subjectAdd')->name('subject/add/page'); // subject/add/page
        Route::post('subject/save', 'saveRecord')->name('subject/save'); // subject/save
        Route::post('subject/update', 'updateRecord')->name('subject/update'); // subject/update
        Route::post('subject/delete', 'deleteRecord')->name('subject/delete'); // subject/delete
        Route::get('subject/edit/{subject_id}', 'subjectEdit'); // subject/edit/page
    });

    // ----------------------- invoice -----------------------------//
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('invoice/list/page', 'invoiceList')->name('invoice/list/page'); // subjeinvoicect/list/page
        Route::get('invoice/paid/page', 'invoicePaid')->name('invoice/paid/page'); // invoice/paid/page
        Route::get('invoice/overdue/page', 'invoiceOverdue')->name('invoice/overdue/page'); // invoice/overdue/page
        Route::get('invoice/draft/page', 'invoiceDraft')->name('invoice/draft/page'); // invoice/draft/page
        Route::get('invoice/recurring/page', 'invoiceRecurring')->name('invoice/recurring/page'); // invoice/recurring/page
        Route::get('invoice/cancelled/page', 'invoiceCancelled')->name('invoice/cancelled/page'); // invoice/cancelled/page
        Route::get('invoice/grid/page', 'invoiceGrid')->name('invoice/grid/page'); // invoice/grid/page
        Route::get('invoice/add/page', 'invoiceAdd')->name('invoice/add/page'); // invoice/add/page
        Route::post('invoice/add/save', 'saveRecord')->name('invoice/add/save'); // invoice/add/save
        Route::post('invoice/update/save', 'updateRecord')->name('invoice/update/save'); // invoice/update/save
        Route::post('invoice/delete', 'deleteRecord')->name('invoice/delete'); // invoice/delete
        Route::get('invoice/edit/{invoice_id}', 'invoiceEdit')->name('invoice/edit/page'); // invoice/edit/page
        Route::get('invoice/view/{invoice_id}', 'invoiceView')->name('invoice/view/page'); // invoice/view/page
        Route::get('invoice/settings/page', 'invoiceSettings')->name('invoice/settings/page'); // invoice/settings/page
        Route::get('invoice/settings/tax/page', 'invoiceSettingsTax')->name('invoice/settings/tax/page'); // invoice/settings/tax/page
        Route::get('invoice/settings/bank/page', 'invoiceSettingsBank')->name('invoice/settings/bank/page'); // invoice/settings/bank/page
    });

    // ----------------------- accounts ----------------------------//
    Route::controller(AccountsController::class)->group(function () {
        Route::get('account/fees/collections/page', 'index')->name('account/fees/collections/page'); // account/fees/collections/page
        Route::get('add/fees/collection/page', 'addFeesCollection')->name('add/fees/collection/page'); // add/fees/collection
        Route::post('fees/collection/save', 'saveRecord')->name('fees/collection/save'); // fees/collection/save
    });
});
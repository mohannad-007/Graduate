<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\Users\AdminDiagnosisController;
use App\Http\Controllers\Admin\Users\AdminSectionsController;
use App\Http\Controllers\Admin\Users\AdminSupervisorsController;
use App\Http\Controllers\Diagnosis\DiagnosisAuthController;
use App\Http\Controllers\Diagnosis\DiagnosisProfileController;
use App\Http\Controllers\Patient\HealthRecordController;
use App\Http\Controllers\Patient\PatientAuthController;
use App\Http\Controllers\Patient\PatientBookAppointmentDiagnosisController;
use App\Http\Controllers\Patient\PatientProfileController;
use App\Http\Controllers\Patient\PatientSessionController;
use App\Http\Controllers\Patient\PatientTestResultsAfterDiagnosisController;
use App\Http\Controllers\Section\SectionAuthController;
use App\Http\Controllers\Section\SectionProfileController;
use App\Http\Controllers\Student\StudentAuthController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Http\Controllers\Supervisor\SupervisorAuthController;
use App\Http\Controllers\Supervisor\SupervisorProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\PatientVisetedController;
use App\Http\Controllers\Patient\PatientAppointmentController;
use App\Http\Controllers\Patient\PatientToolsRequiredController;
use App\Http\Controllers\Student\StudentSectionsViewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Patient /////////////////////////////////////////////////////////////////////
Route::post('patient/auth/register', [PatientAuthController::class, 'register']);
Route::post('/patient/auth/login', [PatientAuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum', 'patient']], function () {
    Route::post('/patient/auth/logout', [PatientAuthController::class, 'logout']);
    Route::prefix('/patient/profile')->group(function ()
    {
        Route::post('create', [PatientProfileController::class, 'create']);
        Route::get('showProfileInfo', [PatientProfileController::class, 'showProfileInfo']);
        Route::post('createHealthRecord', [HealthRecordController::class, 'createHealthRecord']);
        Route::get('showPatientCaseByPatientId', [PatientTestResultsAfterDiagnosisController::class, 'showPatientCaseByPatientId']);
        Route::get('patientSession', [PatientSessionController::class, 'patientSession']);
//        Route::get('test', [PatientSessionController::class, 'test']);
        Route::post('bookAppointment', [PatientBookAppointmentDiagnosisController::class, 'bookAppointment']);
        Route::get('viseted', [PatientVisetedController::class, 'viseted']);
        Route::get('myAppointment', [PatientAppointmentController::class, 'myAppointment']);
        Route::get('toolsRequired', [PatientToolsRequiredController::class, 'toolsRequired']);

    });
});
//////////////////////////////////////////////////////////////////////////////////

//Student//////////////////////////////////////////////////////////////////////////
Route::post('student/auth/register', [StudentAuthController::class, 'register']);
Route::post('student/auth/login', [StudentAuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum', 'student']], function () {
    Route::post('/student/auth/logout', [StudentAuthController::class, 'logout']);
    Route::prefix('/student/profile')->group(function ()
    {
        Route::post('edit', [StudentProfileController::class, 'edit']);
        Route::get('sectionsView', [StudentSectionsViewController::class, 'sectionsView']);
    });
});
//////////////////////////////////////////////////////////////////////////////////


///Admin//////////////////////////////////////////////////////////////////////////
//-------------------------------------------------------------------------------
//Admin Profile Management-------------------------------------------------------
Route::post('admin/auth/register', [AdminAuthController::class, 'register']);
Route::post('admin/auth/login', [AdminAuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
    Route::post('/admin/auth/logout', [AdminAuthController::class, 'logout']);
    Route::post('/admin/profile/edit', [AdminProfileController::class, 'edit']);

});
//-------------------------------------------------------------------------------
/// Admin Management Supervisors Accounts----------------------------------------
Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
    Route::prefix('admin/users/supervisors')->group(function ()
    {
        Route::post('add', [AdminSupervisorsController::class, 'register']);
        Route::delete('delete', [AdminSupervisorsController::class, 'delete']);
        Route::post('edit', [AdminSupervisorsController::class, 'edit']);
    });
});
//--------------------------------------------------------------------------------
/// Admin Management Diagnosis Accounts----------------------------------------
Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
    Route::prefix('admin/users/diagnosis')->group(function ()
    {
        Route::post('add', [AdminDiagnosisController::class, 'register']);
        Route::delete('delete', [AdminDiagnosisController::class, 'delete']);
        Route::post('edit', [AdminDiagnosisController::class, 'edit']);
    });
});
//--------------------------------------------------------------------------------
/// Admin Management Sections Accounts----------------------------------------
Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
    Route::prefix('admin/users/sections')->group(function ()
    {
        Route::post('add', [AdminSectionsController::class, 'register']);
        Route::delete('delete', [AdminSectionsController::class, 'delete']);
        Route::post('edit', [AdminSectionsController::class, 'edit']);
    });
});
//--------------------------------------------------------------------------------

//Supervisor//////////////////////////////////////////////////////////////////////////
Route::post('supervisor/auth/login', [SupervisorAuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum', 'supervisor']], function () {
    Route::post('/supervisor/auth/logout', [SupervisorAuthController::class, 'logout']);
    Route::prefix('/supervisor/profile')->group(function ()
    {
        Route::post('edit', [SupervisorProfileController::class, 'edit']);
    });
});
//////////////////////////////////////////////////////////////////////////////////
//Diagnosis//////////////////////////////////////////////////////////////////////////
Route::post('diagnosis/auth/login', [DiagnosisAuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum', 'diagnosis']], function () {
    Route::post('/diagnosis/auth/logout', [DiagnosisAuthController::class, 'logout']);
    Route::prefix('/diagnosis/profile')->group(function ()
    {
        Route::post('edit', [DiagnosisProfileController::class, 'edit']);
    });
});
//////////////////////////////////////////////////////////////////////////////////
//Sections//////////////////////////////////////////////////////////////////////////
Route::post('section/auth/login', [SectionAuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum', 'section']], function () {
    Route::post('/section/auth/logout', [SectionAuthController::class, 'logout']);
    Route::prefix('/section/profile')->group(function ()
    {
        Route::post('edit', [SectionProfileController::class, 'edit']);
    });
});
//////////////////////////////////////////////////////////////////////////////////

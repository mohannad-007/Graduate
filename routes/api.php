<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\Users\AdminDiagnosisController;
use App\Http\Controllers\Admin\Users\AdminSectionsController;
use App\Http\Controllers\Admin\Users\AdminSupervisorsController;
use App\Http\Controllers\Diagnosis\DiagnosisAuthController;
use App\Http\Controllers\Diagnosis\DiagnosisProfileController;
use App\Http\Controllers\Diagnosis\PatientAcceptAppointmentController;
use App\Http\Controllers\Diagnosis\PatientSortingViaStudentsController;
use App\Http\Controllers\Diagnosis\PatientViewAcceptedController;
use App\Http\Controllers\Diagnosis\PatientViewCurrentController;
use App\Http\Controllers\Diagnosis\PatientViewPendingController;
use App\Http\Controllers\Diagnosis\StudentGiveRulesDiagnosisController;
use App\Http\Controllers\Diagnosis\StudentViewController;
use App\Http\Controllers\Patient\HealthRecordController;
use App\Http\Controllers\Patient\PatientAuthController;
use App\Http\Controllers\Patient\PatientBookAppointmentDiagnosisController;
use App\Http\Controllers\Patient\PatientProfileController;
use App\Http\Controllers\Patient\PatientSessionController;
use App\Http\Controllers\Patient\PatientTestResultsAfterDiagnosisController;
use App\Http\Controllers\Section\SectionAuthController;
use App\Http\Controllers\Section\SectionCasesController;
use App\Http\Controllers\section\SectionPatientController;
use App\Http\Controllers\Section\SectionProfileController;
use App\Http\Controllers\Section\SectionStudentController;
use App\Http\Controllers\Section\SectionSupervisorController;
use App\Http\Controllers\Student\StudentAuthController;
use App\Http\Controllers\Student\StudentConvertToSectionController;
use App\Http\Controllers\Student\StudentDiagnosisCasesController;
use App\Http\Controllers\Student\StudentImportantToolsController;
use App\Http\Controllers\Student\StudentPatientHealthRecordController;
use App\Http\Controllers\Student\StudentPatientNowController;
use App\Http\Controllers\Student\StudentPatientSessionsController;
use App\Http\Controllers\Student\StudentPatientToolsRequiredController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Http\Controllers\Student\StudentProfileViewController;
use App\Http\Controllers\Student\StudentSectionController;
use App\Http\Controllers\Student\StudentSessionController;
use App\Http\Controllers\Student\StudentToolsRequiredController;
use App\Http\Controllers\Supervisor\GetSupervisorClinicController;
use App\Http\Controllers\Supervisor\PatientRelatedWithSessionsController;
use App\Http\Controllers\Supervisor\SessionDetailsController;
use App\Http\Controllers\Supervisor\StudetInCliniclsController;
use App\Http\Controllers\Supervisor\StudetPetientsController;
use App\Http\Controllers\Supervisor\SupervisorAuthController;
use App\Http\Controllers\Supervisor\SupervisorProfileController;
use App\Http\Controllers\Supervisor\SupervisorSectionController;
use App\Http\Controllers\Supervisor\SupervisorSessionController;
use App\Http\Controllers\Supervisor\SupervisorSessionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\PatientVisetedController;
use App\Http\Controllers\Patient\PatientAppointmentController;
use App\Http\Controllers\Patient\PatientToolsRequiredController;
use App\Http\Controllers\Student\StudentSectionsViewController;
use App\Http\Controllers\Student\StudentPatientViewController;
use App\Http\Controllers\Student\StudentUpdateHealthRecordController;
use App\Http\Controllers\Student\StudentSendPatientController;
use App\Http\Controllers\Student\StudentAppointmentController;
use App\Http\Controllers\Patient\PatientRelatedWithStudentController;
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
        Route::get('patientSessionRelatedWithStudent', [PatientSessionController::class, 'patientSessionRelatedWithStudent']);
//        Route::get('test', [PatientSessionController::class, 'test']);
        Route::post('bookAppointment', [PatientBookAppointmentDiagnosisController::class, 'bookAppointment']);
        Route::get('viseted', [PatientVisetedController::class, 'viseted']);
        Route::get('archiveVisited', [PatientVisetedController::class, 'archiveVisited']);
        Route::get('myAppointment', [PatientAppointmentController::class, 'myAppointment']);
        Route::get('archiveMyAppointment', [PatientAppointmentController::class, 'archiveMyAppointment']);
        Route::get('toolsRequired', [PatientToolsRequiredController::class, 'toolsRequired']);
        Route::get('viewDiseases', [HealthRecordController::class, 'viewDiseases']);
        Route::get('viewHealthRecord', [HealthRecordController::class, 'viewHealthRecord']);
        Route::get('patientRelatedWithStudent', [PatientRelatedWithStudentController::class, 'patientRelatedWithStudent']);

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
        Route::get('getClinicsBySectionId', [StudentSectionsViewController::class, 'getClinicsBySectionId']);
        Route::get('convertFromSection', [StudentPatientViewController::class, 'convertFromSection']);
        Route::get('convertFromStudent', [StudentPatientViewController::class, 'convertFromStudent']);
        Route::post('updateHealthRecord', [StudentUpdateHealthRecordController::class, 'updateHealthRecord']);
        Route::get('studentViewCases', [StudentSendPatientController::class, 'studentViewCases']);
        Route::post('studentSendCases', [StudentSendPatientController::class, 'studentSendCases']);
        Route::post('toolsRequired', [StudentToolsRequiredController::class, 'toolsRequired']);
        Route::get('studentDiagnosisCases', [StudentDiagnosisCasesController::class, 'studentDiagnosisCases']);
        Route::get('studentPatientHealthRecord', [StudentPatientHealthRecordController::class, 'studentPatientHealthRecord']);
        Route::get('studentPatientToolsRequired', [StudentPatientToolsRequiredController::class, 'studentPatientToolsRequired']);
        Route::get('studentPatientSessions', [StudentPatientSessionsController::class, 'studentPatientSessions']);
        Route::get('studentAppointments', [StudentAppointmentController::class, 'studentAppointments']);
        Route::get('studentProfileView', [StudentProfileViewController::class, 'studentProfileView']);
        Route::get('studentPatientNow', [StudentPatientNowController::class, 'studentPatientNow']);
        Route::post('addTools', [StudentImportantToolsController::class, 'addTools']);
        Route::get('getTools', [StudentImportantToolsController::class, 'getTools']);
        Route::delete('destroyTools', [StudentImportantToolsController::class, 'destroyTools']);
        Route::post('addSession', [StudentSessionController::class, 'addSession']);
        Route::put('updateSession', [StudentSessionController::class, 'updateSession']);
        Route::post('addPatientCases', [StudentConvertToSectionController::class, 'addPatientCases']);
        Route::get('tupeOfSections', [StudentConvertToSectionController::class, 'tupeOfSections']);
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
        Route::get('getClinic', [GetSupervisorClinicController::class, 'getClinic']);
        Route::get('getSessionsNotAssignment', [SupervisorSessionsController::class, 'getSessionsNotAssignment']);
        Route::get('getMySessions', [SupervisorSessionsController::class, 'getMySessions']);
        Route::get('sessionDetails', [SessionDetailsController::class, 'sessionDetails']);
        Route::put('addSessionNotes', [SessionDetailsController::class, 'addSessionNotes']);
        Route::get('studentInClinics', [StudetInCliniclsController::class, 'studentInClinics']);
        Route::get('studentPatient', [StudetPetientsController::class, 'studentPatient']);
        Route::get('patientRelatedWithSessions', [PatientRelatedWithSessionsController::class, 'patientRelatedWithSessions']);
        Route::get('getMySections', [SupervisorSectionController::class, 'getMySections']);
        Route::get('getClinicsBySectionId', [SupervisorSectionController::class, 'getClinicsBySectionId']);
        Route::get('getSessionToday', [SupervisorSessionController::class, 'getSessionToday']);
        Route::get('getPatientToday', [SupervisorSessionController::class, 'getPatientToday']);
        Route::get('getStudentsRelatedPatient', [SupervisorSessionController::class, 'getStudentsRelatedPatient']);
        Route::get('getSessionsRelatedPatientStudent', [SupervisorSessionController::class, 'getSessionsRelatedPatientStudent']);

    });
});
//////////////////////////////////////////////////////////////////////////////////



//Diagnosis//////////////////////////////////////////////////////////////////////////
Route::post('diagnosis/auth/login', [DiagnosisAuthController::class,'login']);
Route::group(['middleware' => ['auth:sanctum', 'diagnosis']], function () {
    Route::post('/diagnosis/auth/logout', [DiagnosisAuthController::class,'logout']);
    Route::prefix('/diagnosis/profile')->group(function ()
    {
        Route::post('edit', [DiagnosisProfileController::class,'edit']);
        Route::get('pendingPatientView', [PatientViewPendingController::class,'pendingPatientView']);
        Route::get('acceptPatientView', [PatientViewAcceptedController::class,'acceptPatientView']);
        Route::get('currentPatientView', [PatientViewCurrentController::class,'currentPatientView']);
        Route::put('acceptPatientAppointment', [PatientAcceptAppointmentController::class,'acceptPatientAppointment']);
        Route::get('studentView', [StudentViewController::class,'studentView']);
        Route::get('studentTrueDiagnosisView', [StudentViewController::class,'studentTrueDiagnosisView']);
        Route::post('studentGiveRules', [StudentGiveRulesDiagnosisController::class,'studentGiveRules']);
        Route::get('patientSortingViaStudents', [PatientSortingViaStudentsController::class,'patientSortingViaStudents']);


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
        Route::get('showPatientsInCurrentChapter', [SectionPatientController::class, 'showPatientsInCurrentChapter']);
        Route::post('addReferralToStudent', [SectionStudentController::class, 'addReferralToStudent']);
        Route::post('addTypeOfCases', [SectionCasesController::class, 'addTypeOfCases']);
        Route::post('addSuperVisorTimeToClinic', [SectionSupervisorController::class, 'addSuperVisorTimeToClinic']);
    });
});
//////////////////////////////////////////////////////////////////////////////////

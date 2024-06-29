<?php

use App\Http\Controllers\Admin\Users\StudentImportController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

//    phpinfo();    return view('welcome');
});

Route::post('/import-students', [StudentImportController::class, 'import'])->name('import.students');
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


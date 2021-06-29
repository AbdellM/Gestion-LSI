<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfController;
use App\Http\Controllers\PfeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('getall/{id}', 'App\Http\Controllers\StudentController@update'); 
// Route::DELETE('getall/{id}', 'App\Http\Controllers\StudentController@destroy'); 
// Route::get('getall', 'App\Http\Controllers\StudentController@index'); 
// Route::post('getall', 'App\Http\Controllers\StudentController@store'); 
// Route::post('register', 'App\Http\Controllers\AuthController@register'); 


Route::group([ 'middleware' => 'api', 'prefix' => 'auth'], function ($router) {

    Route::post('login', 'App\Http\Controllers\AuthController@login'); 
    Route::post('logout', 'App\Http\Controllers\AuthController@logout'); 
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh'); 
    Route::get('user-profile', 'App\Http\Controllers\AuthController@userProfile');

    
    
    Route::group([ 'middleware' => 'isAdmin', 'prefix' => 'admin'], function ($router) {
        Route::get('module', 'App\Http\Controllers\ModuleController@index'); 
        Route::get('getStudents/{semestre}', 'App\Http\Controllers\StudentController@getStudentsBySemester'); 
        
        Route::apiResource('gestionstudent', App\Http\Controllers\StudentController::class);
        Route::apiResource('gestionProf', App\Http\Controllers\ProfController::class);
        Route::apiResource('gestionAdmin', App\Http\Controllers\AdminController::class);
        Route::apiResource('gestionPfe', App\Http\Controllers\PfeController::class);
        Route::apiResource('gestionSeance', App\Http\Controllers\SeanceController::class);
    });    
    
    Route::group([ 'middleware' => 'isProf', 'prefix' => 'prof'], function ($router) {
        Route::get('pfe', 'App\Http\Controllers\PfeController@showP'); 
        Route::get('module', 'App\Http\Controllers\ProfController@showM');
        Route::get('note/{id}', 'App\Http\Controllers\NoteController@showP');
        Route::put('note/{id}', 'App\Http\Controllers\NoteController@update'); 
        Route::get('emploi', 'App\Http\Controllers\SeanceController@showP');
    });

    Route::group([ 'middleware' => 'isStudent', 'prefix' => 'student'], function ($router) {
        Route::get('pfe', 'App\Http\Controllers\PfeController@showE'); 
        Route::get('note', 'App\Http\Controllers\NoteController@showE'); 
        Route::get('emploi', 'App\Http\Controllers\SeanceController@showE'); 
    });
});

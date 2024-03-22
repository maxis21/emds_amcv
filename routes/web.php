<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebScrapingController;

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


/*------------------------------------------------------------------------
    Show Routes
------------------------------------------------------------------------*/
Route::get('/', [AuthController::class, 'login'])->name('to.Login');
Route::post('/user/login', [AuthController::class, 'postLogin'])->name('to.Auth');
Route::get('/user/logout', [AuthController::class, 'logout'])->name('to.Logout');



/*---------------------------------MIDDLEWARE------------------------------------------------*/
Route::group(['middleware' => ['auth', 'role:super-admin,admin']], function () {
    Route::post('/user/register', [AuthController::class, 'register'])->name('to.Add');
    Route::post('/update', [UsersController::class, 'active'])->name('to.Set');
    Route::get('/fetch/{id}', [UsersController::class, 'fetch'])->name('to.Fetch');
    Route::get('/users', [UsersController::class, 'show'])->name('to.Users');


    /*----------------------------------------------------------------------
        Users Routes
    ----------------------------------------------------------------------*/
    Route::get('/Users', [UsersController::class, 'Users'])->name('display.Users');
    Route::get('/Users', [UsersController::class, 'UserRoles'])->name('select.Role');
    Route::put('/Users/update', [UsersController::class, 'UserUpdate'])->name('update.User');
    Route::put('/Users/password-reset', [UsersController::class, 'resetPassword'])->name('password.reset');
});


Route::group(['middleware' => ['auth', 'role:super-admin']], function () {

    /*----------------------------------------------------------------------
        Department Routes
    ----------------------------------------------------------------------*/
    Route::get('/departments', [DepartmentController::class, 'show'])->name('to.Departments');
    Route::get('/Departments/{id}/files', [DepartmentController::class, 'showFiles'])->name('show.deptFiles');
    Route::post('/Departments/Add-Department', [DepartmentController::class, 'addDept'])->name('add.dept');

});


Route::group(['middleware' => ['auth', 'role:super-admin,admin,user']], function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('to.Dashboard');
    Route::get('/documents', [DocumentController::class, 'show'])->name('to.Documents');
    Route::get('/request', [RequestController::class, 'show'])->name('to.Request');

    /*----------------------------------------------------------------------
        Document Routes
    ----------------------------------------------------------------------*/
    Route::post('/document/addFile', [DocumentController::class, 'uploadFile'])->name('upload.file');
    Route::post('/document/requestFile', [DocumentController::class, 'requestFile'])->name('request.File');

    // Test Route
    Route::get('/phDownload', [WebScrapingController::class, 'phPDF'])->name('try.This');

});
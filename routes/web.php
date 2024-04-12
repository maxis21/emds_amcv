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



/*---------------------------------------MIDDLEWARE------------------------------------------*/
// *_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*
Route::group(['middleware' => ['auth', 'role:super-admin,admin']], function () {
    Route::post('/user/register', [AuthController::class, 'register'])->name('to.Add');
    Route::post('/update', [UsersController::class, 'active'])->name('to.Set');
    Route::get('/fetch/{id}', [UsersController::class, 'fetch'])->name('to.Fetch');
    Route::get('/users', [UsersController::class, 'show'])->name('to.Users');


    /*----------------------------------------------------------------------
        Dashboard Routes
    ----------------------------------------------------------------------*/
    Route::get('/dashboard-admin', [DashboardController::class, 'show_dashAdmin'])->name('to.DashAdmin');

    /*----------------------------------------------------------------------
        Users Routes
    ----------------------------------------------------------------------*/
    Route::get('/Users', [UsersController::class, 'Users'])->name('display.Users');
    Route::get('/Users', [UsersController::class, 'UserRoles'])->name('select.Role');
    Route::put('/Users/update', [UsersController::class, 'UserUpdate'])->name('update.User');
    Route::put('/Users/password-reset', [UsersController::class, 'resetPassword'])->name('password.reset');


    /*----------------------------------------------------------------------
        Document Routes
    ----------------------------------------------------------------------*/
    Route::get('/admin/documents', [DocumentController::class, 'show_docADminview'])->name('to.Documents-admin');
    Route::post('/document/addFile', [DocumentController::class, 'uploadFile'])->name('upload.file');

    /*----------------------------------------------------------------------
        Request Routes
    ----------------------------------------------------------------------*/
    Route::get('/request', [RequestController::class, 'show'])->name('to.Request');
    Route::get('/request-admin', [RequestController::class, 'showRequest_adminView'])->name('to.Request.admin');

    Route::get('/Dept-Users', [UsersController::class, 'Users_adminView'])->name('display.Users.admins');

    /*----------------------------------------------------------------------
        Request Routes
    ----------------------------------------------------------------------*/
    Route::put('/request/approve-request/{id}', [RequestController::class, 'approveReq'])->name('approve.request');
});

// *_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*
Route::group(['middleware' => ['auth', 'role:super-admin']], function () {
    Route::get('/documents', [DocumentController::class, 'show'])->name('to.Documents');

    /*----------------------------------------------------------------------
        Dashboard Routes
    ----------------------------------------------------------------------*/
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('to.Dashboard');

    /*----------------------------------------------------------------------
        Department Routes
    ----------------------------------------------------------------------*/
    Route::get('/departments', [DepartmentController::class, 'show'])->name('to.Departments');
    Route::get('/Departments/{id}/files', [DepartmentController::class, 'showFiles'])->name('show.deptFiles');
    Route::post('/Departments/Add-Department', [DepartmentController::class, 'addDept'])->name('add.dept');
});

// *_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*
Route::group(['middleware' => ['auth', 'role:super-admin,admin,user']], function () {

    // Route::get('/request', [RequestController::class, 'show'])->name('to.Request');

    /*----------------------------------------------------------------------
        Document Routes
    ----------------------------------------------------------------------*/
    

    /*----------------------------------------------------------------------
        Requests Routes
    ----------------------------------------------------------------------*/
    Route::get('/request/status', [RequestController::class, 'fileStatus'])->name('file.Status');

    // Test Route ------------------------------------------------------------------------
    Route::get('/phDownload', [WebScrapingController::class, 'phPDF'])->name('try.This');
});

// *_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*
Route::group(['middleware' => ['auth', 'role:user']], function (){

    /*----------------------------------------------------------------------
        Dashboard Routes
    ----------------------------------------------------------------------*/
    Route::get('/dashboard-user', [DashboardController::class, 'show_dashUser'])->name('to.DashUser');


    /*----------------------------------------------------------------------
        Document Routes
    ----------------------------------------------------------------------*/
    Route::get('/user/documents', [DocumentController::class, 'show_docUserview'])->name('to.Documents-user');
    Route::post('/document/requestFile', [DocumentController::class, 'requestFile'])->name('request.File');


    /*----------------------------------------------------------------------
        Request Routes
    ----------------------------------------------------------------------*/
    Route::get('/request-user', [RequestController::class, 'show_requestUser'])->name('to.request-user');
    Route::get('request/document/{id}/download', [RequestController::class, 'download_document'])->name('download.Docs');


});

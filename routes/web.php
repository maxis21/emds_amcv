<?php

use App\Http\Controllers\IntervalControllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DirectoryController;
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


Route::get('/browse', function () {

    $basePath = 'storage'; // Set the base path to the 'storage' folder in public

    $contents = Storage::allFiles(''); // Get all files recursively
    $directories = Storage::allDirectories('');

    return view('browse', compact('contents', 'directories'));
})->name('to.Home');

Route::get('/browse/fetch', [DirectoryController::class, 'fetchFolderContents'])->name('fetchFolderContents');

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
    Route::get('/View/File/{originalFile}', [DocumentController::class, 'viewFile'])->name('view.file');
    Route::get('/admin/documents/{name}/{folderId}', [DocumentController::class, 'adminTrackFile'])->name('adminFolders.show');
    Route::get('/User-Uploads', [DocumentController::class, 'viewUserUploads'])->name('view.userUploads');
    Route::put('/uploads/approve-file/{id}', [DocumentController::class, 'approveFile'])->name('approve.file');
    Route::put('/uploads/decline-file/{id}', [DocumentController::class, 'declineFile'])->name('decline.file');

    /*----------------------------------------------------------------------
        Request Routes
    ----------------------------------------------------------------------*/
    Route::get('/request', [RequestController::class, 'show'])->name('to.Request');
    Route::get('/request-admin', [RequestController::class, 'showRequest_adminView'])->name('to.Request.admin');
    Route::get('/Dept-Users', [UsersController::class, 'Users_adminView'])->name('display.Users.admins');
    Route::put('/request/approve-request/{id}', [RequestController::class, 'approveReq'])->name('approve.request');
    Route::put('/request/decline-request/{id}', [RequestController::class, 'declineReq'])->name('decline.request');
});

// *_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*
Route::group(['middleware' => ['auth', 'role:super-admin']], function () {

    /*----------------------------------------------------------------------
        Dashboard Routes
    ----------------------------------------------------------------------*/
    Route::get('/documents', [DocumentController::class, 'show'])->name('to.Documents');
    Route::get('/documents/{name}/{folderId}', [DocumentController::class, 'trackFile'])->name('folders.show');


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
    Route::post('/Create-Folder', [DocumentController::class, 'createFolder'])->name('create.folder');
    Route::post('/document/addFile', [DocumentController::class, 'uploadFile'])->name('upload.file');


    /*----------------------------------------------------------------------
        Requests Routes
    ----------------------------------------------------------------------*/
    Route::get('/request/status', [RequestController::class, 'fileStatus'])->name('file.Status');

    // Test Route ------------------------------------------------------------------------
    Route::get('/phDownload', [WebScrapingController::class, 'phPDF'])->name('try.This');


    // Intervals controller 
    // Intervals 
    Route::get('/dashboard/show/online', [IntervalControllers::class, 'retrieveOnlineUsers'])->name('intervals.users');
});

// *_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*_*
Route::group(['middleware' => ['auth', 'role:user']], function () {

    /*----------------------------------------------------------------------
        Dashboard Routes
    ----------------------------------------------------------------------*/
    Route::get('/dashboard-user', [DashboardController::class, 'show_dashUser'])->name('to.DashUser');


    /*----------------------------------------------------------------------
        Document Routes
    ----------------------------------------------------------------------*/
    Route::get('/user/documents', [DocumentController::class, 'show_docUserview'])->name('to.Documents-user');
    Route::post('/document/requestFile', [DocumentController::class, 'requestFile'])->name('request.File');
    Route::get('/user/documents/{name}/{folderId}', [DocumentController::class, 'userTrackFile'])->name('userFolders.show');
    Route::post('/user/documents/uploadfile/', [DocumentController::class, 'userUploads'])->name('user.upload.file');


    /*----------------------------------------------------------------------
        Request Routes
    ----------------------------------------------------------------------*/
    Route::get('/request-user', [RequestController::class, 'show_requestUser'])->name('to.request-user');
    Route::get('request/document/{id}/download', [RequestController::class, 'download_document'])->name('download.Docs');
});

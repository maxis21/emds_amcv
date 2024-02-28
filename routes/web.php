<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;

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

/*
------------------------------------------------------------------------
    Show Routes
------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'login'])->name('to.Login');
Route::post('/user/login', [AuthController::class,'postLogin'])->name('to.Auth');
Route::get('/user/logout', [AuthController::class,'logout'])->name('to.Logout');

Route::get('/dashboard', [DashboardController::class, 'show'])->name('to.Dashboard');
Route::get('/departments', [DepartmentController::class, 'show'])->name('to.Departments');
Route::get('/documents', [DocumentController::class, 'show'])->name('to.Documents');
Route::get('/request', [RequestController::class, 'show'])->name('to.Request');
Route::get('/users', [UsersController::class, 'show'])->name('to.Users');

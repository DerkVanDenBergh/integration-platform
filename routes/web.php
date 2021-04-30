<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\DataModelController;
use App\Http\Controllers\EndpointController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MappingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\StepFunctionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PageController;

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

// Non-model pages

Route::get('/', [PageController::class, 'welcome'])->name('welcome');

Route::get('/dashboard', [PageController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::get('/manage', [PageController::class, 'manage'])->middleware(['auth'])->name('manage');


// Data models

Route::resource('models', DataModelController::class)->middleware(['auth']);


// Data mappings

Route::resource('mappings', MappingController::class)->middleware(['auth']);


// Connections

Route::resource('connections', ConnectionController::class)->middleware(['auth']);


// Endpoints

Route::resource('endpoints', EndpointController::class)->middleware(['auth']);


// Routes

Route::resource('routes', RouteController::class)->middleware(['auth']);


// Tasks

Route::resource('tasks', TaskController::class)->middleware(['auth']);


// Authentications

Route::resource('authentications', AuthenticationController::class)->middleware(['auth']);


// Roles

Route::resource('roles', RoleController::class)->middleware(['auth']);


// Functions

Route::resource('functions', FunctionController::class)->middleware(['auth']);


// Logs

Route::resource('logs', LogController::class)->middleware(['auth']);


// Notifications

Route::resource('notifications', NotificationController::class)->middleware(['auth']);


// Requires

require __DIR__.'/auth.php';

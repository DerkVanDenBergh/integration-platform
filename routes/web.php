<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\DataModelController;
use App\Http\Controllers\DataModelFieldController;
use App\Http\Controllers\EndpointController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MappingController;
use App\Http\Controllers\MappingFieldController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\StepFunctionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\HookController;
use App\Http\Controllers\RunController;

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

// Hooks

Route::get('/hooks/{slug}', [HookController::class, 'get'])->name('hook.get');
Route::post('/hooks/{slug}', [HookController::class, 'post'])->name('hook.post');
Route::patch('/hooks/{slug}', [HookController::class, 'put'])->name('hook.patch');
Route::put('/hooks/{slug}', [HookController::class, 'put'])->name('hook.put');
Route::delete('/hooks/{slug}', [HookController::class, 'delete'])->name('hook.delete');

// Non-model pages

Route::get('/', [PageController::class, 'welcome'])->name('welcome');

Route::get('/dashboard', [PageController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::get('/manage', [PageController::class, 'manage'])->middleware(['auth'])->name('manage');


// Data models

Route::resource('models', DataModelController::class)->middleware(['auth']);

Route::post('/models/create', [DataModelController::class, 'wizard'])->middleware(['auth'])->name('models.wizard');
Route::post('/models/create/definition', [DataModelController::class, 'definition'])->middleware(['auth'])->name('models.definition');


// Data model fields

Route::resource('models.fields', DataModelFieldController::class)->middleware(['auth'])->shallow()->middleware(['auth']);



// Connections

Route::resource('connections', ConnectionController::class)->middleware(['auth']);

Route::post('/connections/create', [ConnectionController::class, 'wizard'])->middleware(['auth'])->name('connections.wizard');
Route::post('/connections/create/template', [ConnectionController::class, 'template'])->middleware(['auth'])->name('connections.template');


// Connection templates

Route::get('/templates', [ConnectionController::class, 'templates'])->middleware(['auth'])->name('templates');


// Endpoints

Route::resource('connections.endpoints', EndpointController::class)->shallow()->middleware(['auth']);

Route::post('/connections/{connection}/endpoints/create', [EndpointController::class, 'wizard'])->middleware(['auth'])->name('connections.endpoints.wizard');

Route::get('/endpoints/{endpoint}/model', [EndpointController::class, 'model_edit'])->middleware(['auth'])->name('endpoints.model_edit');
Route::post('/endpoints/{endpoint}/model', [EndpointController::class, 'model_update'])->middleware(['auth'])->name('endpoints.model_update');

// Authentications

Route::resource('connections.authentications', AuthenticationController::class)->shallow()->middleware(['auth']);

Route::get('/authentications', [AuthenticationController::class, 'index'])->name('authentications.index')->middleware(['auth']);

Route::post('/connections/{connection}/authentications/create', [AuthenticationController::class, 'wizard'])->middleware(['auth'])->name('connections.authentications.wizard');


// Routes

Route::resource('routes', RouteController::class)->middleware(['auth']);


// Tasks

Route::resource('tasks', TaskController::class)->middleware(['auth']);

Route::get('/tasks/{task}/execute', [TaskController::class, 'execute'])->middleware(['auth']);


// Data mappings

Route::get('/processables/{processable}/mappings/{mapping}/edit', [MappingController::class, 'edit'])->middleware(['auth']);

Route::post('/processables/{processable}/mappings/{mapping}', [MappingController::class, 'update'])->middleware(['auth']);


// Data mapping fields  

Route::get('/processables/{processable}/mappings/{mapping}/fields', [MappingFieldController::class, 'edit'])->middleware(['auth']);

Route::post('/processables/{processable}/mappings/{mapping}/fields', [MappingFieldController::class, 'update'])->middleware(['auth']);


// Mapping steps

Route::get('/processables/{processable}/steps', [StepController::class, 'edit'])->middleware(['auth']);

Route::post('/processables/{processable}/steps', [StepController::class, 'update'])->middleware(['auth']);

Route::post('/processables/{processable}/steps/component', [StepController::class, 'component'])->middleware(['auth']);


// Roles

Route::resource('roles', RoleController::class)->middleware(['auth']);


// Functions

//Route::resource('functions', FunctionController::class)->middleware(['auth']);


// Logs

Route::resource('logs', LogController::class)->middleware(['auth']);


// Runs

Route::resource('runs', RunController::class)->middleware(['auth']);


// Users

Route::resource('users', UserController::class)->middleware(['auth']);
// Requires

require __DIR__.'/auth.php';

<?php

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



use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware(['auth'])->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');


    Route::get('/projects', 'ProjectsController@index')->name('projects');
    Route::get('/projects/create', 'ProjectsController@create')->name('create.project');
    Route::get('/projects/{project}', 'ProjectsController@show')->name('show.project');
    Route::get('/projects/{project}/edit', 'ProjectsController@edit')->name('edit.project');
    Route::patch('/projects/{project}', 'ProjectsController@update')->name('update.project');
    Route::post('/projects', 'ProjectsController@store')->name('store.project');


    Route::post('/projects/{project}/tasks', 'ProjectTasksController@store')->name('store.task');
    Route::patch('/projects/{project}/tasks/{task}', 'ProjectTasksController@update')->name('update.task');

});





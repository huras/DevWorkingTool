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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/workdays', 'WorkdayController@index');

Route::post('/note/ajax/update', 'NoteController@updateNote')->name('note.update');
Route::post('/note/ajax/store', 'NoteController@newWorkdaynote')->name('note.store');

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
Route::get('/', 'WorkdayController@index');

Route::group(['prefix' => 'workday'], function () {
    Route::get('/', 'WorkdayController@index')->name('workday.list');
});

Route::group(['prefix' => 'project'], function () {
    Route::get('/', 'ProjectController@index')->name('project.list');
});

Route::group(['prefix' => 'skill'], function () {
    Route::get('/', 'SkillController@index')->name('skill.list');
});

Route::group(['prefix' => 'note'], function () {
    Route::post('/ajax/update', 'NoteController@updateNote')->name('note.update');
    Route::post('/ajax/store', 'NoteController@newWorkdaynote')->name('note.store');
});

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
    Route::get('/store', 'WorkdayController@store')->name('workday.store');
});

Route::group(['prefix' => 'project'], function () {
    Route::get('/', 'ProjectController@index')->name('project.list');
});

Route::group(['prefix' => 'skill'], function () {
    Route::get('/', 'SkillController@index')->name('skill.list');
    Route::get('/ajax/fetchAll/{id}', 'SkillController@fetchAll')->name('skill.fetchAll');
    Route::post('/store', 'SkillController@store')->name('skill.store');
});

Route::group(['prefix' => 'block'], function () {
    // Route::post('/ajax/update', 'NoteController@updateNote')->name('note.update');
    Route::post('/ajax/store/{relationship}', 'BlockController@new');
});

Route::group(['prefix' => 'note'], function () {
    Route::post('/ajax/update', 'NoteController@updateNote')->name('note.update');
    Route::post('/ajax/store/{type}', 'NoteController@newNote')->name('note.store');
    // Route::post('/ajax/update', 'NoteController@updateAjax')->name('note.update');
});

Route::group(['prefix' => 'acesso'], function () {
    Route::get('/projects', 'AcessoController@projects')->name('acesso.projects');
});

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
    Route::post('/store', 'ProjectController@store')->name('project.store');
    Route::get('/{id}/acessos', 'ProjectController@acessos')->name('project.acessos');
    Route::post('/{id}/storeAcesso', 'ProjectController@storeAcesso')->name('project.storeAcesso');
});

Route::group(['prefix' => 'skill'], function () {
    Route::get('/', 'SkillController@index')->name('skill.list');
    Route::get('/ajax/fetchAll/{id}', 'SkillController@fetchAll')->name('skill.fetchAll');
    Route::post('/store', 'SkillController@store')->name('skill.store');
    Route::get('/view/{id}', 'SkillController@view')->name('skill.view');
});

Route::group(['prefix' => 'block'], function () {
    Route::get('/ajax/update', 'BlockController@updateAjax')->name('note.update');
    Route::post('/ajax/store/{relationship}', 'BlockController@new');
    Route::get('/newEmpty/{relationship}/{id}', 'BlockController@newEmpty');
    Route::get('/{idBlock}/ajax/newSkillLink/{idSkill}', 'BlockController@newSkillLink');
});

Route::group(['prefix' => 'note'], function () {
    Route::post('/ajax/update', 'NoteController@updateNote')->name('note.update');
    Route::post('/ajax/store/{type}', 'NoteController@newNote')->name('note.store');
    Route::get('/ajax/ajax/newEmpty/{relationship}/{id}/{type}', 'NoteController@newEmptyAjax');
    Route::get('/newEmpty/{relationship}/{id}/{type}', 'NoteController@newEmpty');
    Route::get('/removeNote/{id}', 'NoteController@removeNote');
    // Route::post('/ajax/update', 'NoteController@updateAjax')->name('note.update');
});

Route::group(['prefix' => 'acesso'], function () {
    Route::get('/projects', 'AcessoController@projects')->name('acesso.projects');
});

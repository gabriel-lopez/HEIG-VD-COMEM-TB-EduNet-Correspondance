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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => ['auth:admin']], function ()
{
    Route::get('admins/{id}/edit', 'AdminController@edit')->name('admins.edit');
    Route::patch('admins/{id}/update', 'AdminController@update')->name('admins.update');


    Route::resource('teachers', 'TeacherController')->only(['index', 'create', 'store', 'destroy']);
    Route::resource('classes', 'ScheduledEducationalActivityController')->only(['index']);
    Route::resource('students', 'StudentController')->only(['index']);

    Route::get('images', 'FileManagerController@index')->name('images.index');
    Route::delete('images/{id}', 'FileManagerController@destroy')->name('images.destroy');
});

Route::group(['middleware' => ['auth:teacher']], function ()
{
    Route::get('messages/moderation', 'MessageController@moderation')->name('messages.moderation');
    Route::post('messages/{id}/release', 'MessageController@release')->name('messages.release');
    Route::post('messages/{id}/repel', 'MessageController@repel')->name('messages.repel');

    Route::post('classes/{id}/activate', 'ScheduledEducationalActivityController@activate')->name('classes.activate');
    Route::post('classes/{id}/deactivate', 'ScheduledEducationalActivityController@activate')->name('classes.deactivate');
});

Route::group(['middleware' => ['auth:admin,teacher']], function ()
{
    Route::resource('teachers', 'TeacherController')->except(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('teachers', 'TeacherController'); //TODO
    Route::resource('classes', 'ScheduledEducationalActivityController')->only(['create', 'destroy']);
    Route::resource('students', 'StudentController')->only(['create', 'destroy']);
});

Route::group(['middleware' => ['auth:admin,student,teacher']], function ()
{
    Route::get('/', 'HomeController@index')->name('home'); //TODO

    Route::resource('keywords', 'KeywordController'); //TODO

    Route::resource('classes', 'ScheduledEducationalActivityController')->except(['index', 'create', 'destroy']);

    Route::resource('students', 'StudentController')->except(['index', 'create', 'destroy']);
    Route::get('students/{id}/correspondents', 'StudentController@correspondents')->name('students.correspondents');


    ///HAHAHAH
    Route::get('students/{student}/contact', 'MessageController@contact_student')->name('students.contact');
    Route::post('students/{student}/contact', 'MessageController@contact_store')->name('students.contact.store');


    Route::get('messages/drafts', 'MessageController@drafts')->name('messages.drafts');
    Route::get('messages/sent', 'MessageController@sent')->name('messages.sent');
    Route::resource('messages', 'MessageController');


    Route::get('messages/{message}/answer', 'MessageController@answer')->name('messages.answer');
    Route::post('messages/{message}/answer', 'MessageController@answer_store')->name('messages.answer.store');


    Route::get('search', 'SearchController@standard')->name('search.show');
    Route::get('search/classes', 'SearchController@classes')->name('search.classes.show');
    Route::get('search/keywords', 'SearchController@keywords')->name('search.keywords.show');
    Route::post('search', 'SearchController@search')->name('search');

    Route::post('upload', 'FileManagerController@uploadImage')->name('images.upload');
    Route::get('download/{id}', 'FileManagerController@downloadImage')->name('images.download');
});

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

Route::get('/', 'QuestionsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*
 * 发送邮件出发url
 */
Route::get('/email/varify/{token}', ['as' => 'email.varify', 'uses' => 'EmailController@varify']);

/*
 * 评论url
 */
Route::post('/questions/{question}/answer', 'AnswersController@store');

/*
 * 关注信息url
 */
Route::post('/api/question/follow', 'QuestionFollowController@followedAjaxAll');
/*
 * 发表问题url
 */
Route::resource('questions', 'QuestionsController', ['names' => [
    'create' => 'question.create',
    'show'   => 'question.show'
]]);
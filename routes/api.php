<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('evaluate', "ExamController@testExam");

Route::post('createExam', "ExamController@add");

Route::post('deleteExam', "ExamController@delete");

Route::post('updateExam', "ExamController@update");

Route::post('getExam', "ExamController@get");

Route::post('getExams', "ExamController@listExams");
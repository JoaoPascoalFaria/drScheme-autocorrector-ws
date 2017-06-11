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

Route::get('play/{exam}/{student}', function ($exam, $student){
    return view('minigame', ['exam' => $exam, 'student' => $student]);
});

Route::get('dashboard', function (){
    return view('dashboard');
});

Route::get('acknowledgement', function (){
    return view('acknowledgement');
});

Route::get('getGame', "GameController@downloadGame");

Route::get('{something}', function ($something){
    return view('pages/'.$something);
});
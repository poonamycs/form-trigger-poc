<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/','FormController@index');
Route::Post('/form-popup','FormController@form_popup');
Route::get('/mail-send','FormController@mail_send');
Route::get('/alot-time-slot','FormController@alot_time_slot');

Route::get('/form','FormController@form');
Route::get('/form-submit','FormController@form_submit');
Route::get('/status-change/{id?}','FormController@statuschange');
Route::get('demo', function () {
    return view('demo');
});

Route::get('progressbar', function () {
    return view('progressbar');
});
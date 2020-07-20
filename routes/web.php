<?php

use Illuminate\Support\Facades\Route;

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
    return view('index');
});

Route::post('/storeimgae', 'ImageUploadController@storeImage')->name('image.store');
Route::post('/data/store', 'ImageUploadController@storeData')->name('data.store');
Route::post('/image/{image}/delete', 'ImageUploadController@deleteImage')->name('image.delete');

Route::get('/get/gallery', 'ImageUploadController@index')->name('index');

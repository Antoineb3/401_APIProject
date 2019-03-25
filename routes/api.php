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


Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

Route::apiResource('authors', 'AuthorAPIController');
Route::apiResource('books', 'BookAPIController');

Route::get('books/{book}/image', 'BookAPIController@showImg');
Route::get('books/isbn/{isbn}', 'BookAPIController@showISBN');
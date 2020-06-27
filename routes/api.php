<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Create a New Data
Route::post('/group-create/{name}/{mobile_num}','ApiController@create');
// Show All Data
Route::get('/groups','ApiController@show');
// Retrieve Data
Route::get('/groups/{id}','ApiController@showbyId');
// Modified retrieve data
Route::put('/group-update/{id}/{name}/{mobile_num}','ApiController@update');
// Delete Data
Route::delete('/group-delete/{id}','ApiController@deletebyId');

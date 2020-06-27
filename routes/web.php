<?php

use Illuminate\Support\Facades\Route;


Route::get('/','DashboardController@index');


Route::get('/groups', 'GroupsController@index');

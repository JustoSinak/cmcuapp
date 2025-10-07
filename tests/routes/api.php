<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UsersController;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
    // return $request->user();

Route::middleware('auth:api')->get('/user', [UsersController::class, 'user']);

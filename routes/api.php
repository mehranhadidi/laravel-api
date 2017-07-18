<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* Public Routes */
Route::post('register', 'RegisterController@register');

/* Protected Routes */
Route::middleware('auth:api')->group(function () {
    // Topics
    Route::resource('topics', 'TopicsController', ['except'=> [
        'create', 'edit'
    ]]);

    // Posts
    Route::resource('topics.posts', 'PostsController', ['except'=> [
        'create', 'edit', 'index'
    ]]);
});
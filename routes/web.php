<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/**
 * GET ROUTES
 */
Route::get('/index', 'InviteController@getAction')
    ->name('index');

/**
 * POST ROUTES
 */
Route::post('/invite', 'InviteController@postAction')
    ->name('invite');

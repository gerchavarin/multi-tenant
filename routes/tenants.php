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

Route::middleware('web')
    ->namespace('App\\Http\\Controllers\\')
    ->group(function ()
{
    Auth::routes();
    
    Route::get('/hello', function () {
        return '<h1>Hello Tenant</h1>';
    });
    
    Route::get('/users', function() {
        dump(app('request')->url());
        dump(App\User::all()->pluck('name'));
    });
});

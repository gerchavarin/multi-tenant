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
    return redirect('tenants');
});


Route::resource('tenants', 'TenantController');

Route::get('email', function(){
    $details['email'] = 'gerchavarin@gmail.com';
    dispatch(new App\Jobs\SendEmailJob($details));
    dd('done');
});
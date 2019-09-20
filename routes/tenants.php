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
    Route::get('/', function () {
        return view('tenant.welcome');
    });

    Auth::routes();

    Route::get('tenant', function(){
        $website = app(Hyn\Tenancy\Environment::class)->tenant();
        return json_encode(['uuid' => $website->uuid]);
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::resource('/enterprises','EnterpriseController');
        Route::resource('/records','RecordController');
        Route::resource('/users','UserController');
    

        Route::get('/enterprises/{id}/records','RecordController@showRecordsInEnterprise')->name('records-enterprises')->middleware('permission:search-records');
        Route::post('/enterprises/{id}/records','RecordController@storeRecordsInEnterprise')->name('add-records-enterprises')->middleware('permission:add-records');
        Route::get('/enterprises/{id}/records/create','RecordController@createRecordsInEnterprise')->name('create-records-enterprises')->middleware('permission:create-records');
        Route::put('/enterprises/{id}/records/{rid}','RecordController@updateRecordsInEnterprise')->name('update-records-enterprises')->middleware('permission:update-records');
        Route::get('/enterprises/{id}/records/{rid}/edit','RecordController@editRecordsInEnterprise')->name('edit-records-enterprises')->middleware('permission:edit-records');
        Route::get('/enterprises/{id}/records/download','RecordController@downloadRecordsInEnterprise')->name('download-records-enterprises');
        Route::post('/enterprises/{id}/records/search','RecordController@searchByDate')->name('search-by-date')->middleware('permission:search-records');;
    
        Route::get('/home', 'HomeController@index')->name('home');
    });

    Route::get('/articles', function () {
        return view('writer');
    });
});

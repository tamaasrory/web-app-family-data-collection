<?php

use Illuminate\Support\Facades\Auth;
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


Auth::routes();

Route::get('/', 'HomeController@index');

Route::prefix('data-sensus')->group(function () {
    /** @see DataSensusController::index() */
    Route::get('/', 'DataSensusController@index');

    /** @see DataSensusController::view() */
    Route::get('/view/{id}', 'DataSensusController@view');

    /** @see DataSensusController::add() */
    Route::get('/add', 'DataSensusController@add');
    /** @see DataSensusController::add() */
    Route::post('/add', 'DataSensusController@add');

    /** @see DataSensusController::edit() */
    Route::get('/edit/{id}', 'DataSensusController@edit');
    /** @see DataSensusController::edit() */
    Route::post('/edit', 'DataSensusController@edit');

    /** @see DataSensusController::delete() */
    Route::post('/delete', 'DataSensusController@delete');
});

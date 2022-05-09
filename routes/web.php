<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/addwallet', function () {return view('home');});
Route::get('/test', function () {return view('home');});
Auth::routes();

Route::get('/home',                 [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('userdata',              [App\Http\Controllers\UserDataController::class, 'index']);
Route::get('alluserdata',           [App\Http\Controllers\UserDataController::class, 'all']);

 
Route::get('userexpense/{id}',      [App\Http\Controllers\UserExpenseController::class, 'index']);
Route::post('userexpense',          [App\Http\Controllers\UserExpenseController::class, 'save']);
Route::get('userexpense',          [App\Http\Controllers\UserExpenseController::class, 'allexp']);
Route::delete('userexpense/{id}',   [App\Http\Controllers\UserExpenseController::class, 'delete']);


Route::get('wallets',               [App\Http\Controllers\WalletController::class, 'index']);
Route::post('reject',               [App\Http\Controllers\WalletController::class, 'reject']);
Route::get('singlewallets',    [App\Http\Controllers\WalletController::class, 'single']);
Route::get('userwallets/{id}',           [App\Http\Controllers\WalletController::class, 'user']);
Route::post('wallet',             [App\Http\Controllers\WalletController::class, 'save']);
Route::delete('wallet/{id}',      [App\Http\Controllers\WalletController::class, 'delete']);
Route::get('allwallets',               [App\Http\Controllers\WalletController::class, 'total']);
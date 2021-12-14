<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

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

Route::get('/quotes', function () {

     User::firstOrCreate([
        "name" => "Jon Snow",
        "email" => "jsnow@world.com",
     ]);

    $countries = config('dictionaries.countries');
    $currencies = config('dictionaries.currencies');

    return view('form', ['countries'=>$countries , 'currencies'=>$currencies]);
})->name('form');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');

});

Route::get('users/create', [UserController::class, 'create'])->name('users.create');
Route::post('users', [UserController::class, 'store'])->name('users.store');

//Route::post('users/{user}', [UserController::class, 'update'])->name('users.update');

Route::get('states/{countryId}', [UserController::class, 'getStates']);
Route::get('cities/{stateId}', [UserController::class, 'getCities']);

Route::get('/countries',[UserController::class, 'getCountryData']);


// Route::post('country/create', [UserController::class, 'createCountry'])->name('countries.create');
// Route::get('countries', [UserController::class, 'indexCountries'])->name('countries.index');



// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');

});

Route::get('users/create', [UserController::class, 'create'])->name('users.create');

Route::post('users', [UserController::class, 'store'])->name('users.store');

Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');

Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/genders', [UserController::class, 'getGender']);

Route::get('/countries',[UserController::class, 'getCountryData']);

Route::get('/states/{countryId}', [UserController::class, 'getStates']);

Route::get('/cities/{stateId}', [UserController::class, 'getCities']);

Route::get('/users', [UserController::class, 'index'])->name('users.index');


// Route::post('country/create', [UserController::class, 'createCountry'])->name('countries.create');
// Route::get('countries', [UserController::class, 'indexCountries'])->name('countries.index');

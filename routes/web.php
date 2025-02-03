<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\WelcomeEmail;
// use App\Models\Users;  

Route::get('/welcome', function () {
    return view('welcome');

})->name('welcome');

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

// Route::get('/send-test-email/{$id}', function() {
//     $user = Users::find($id);

//     if ($user) {
//         // Send the email
//         Mail::to($user->email)->send(new WelcomeEmail($user));
//         return 'Test email sent to ' . $user->email;
//     } else {
//         return 'User not found!';
//     }
// });


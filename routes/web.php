<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\GymPackageController;

Route::get('/register', [AuthController::class, 'register'])->name('register_get');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register_post');
Route::get('/login', [AuthController::class, 'index'])->name('login_get');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login_post');

Route::get('/logout', function ()
{
    Auth::logout();
    return redirect()->route('login_get')->with('success', 'Logged out successfully.');
})->name('logout');


Route::get('/access-denied', function () {
    return view('access_denied');
})->name('access_denied');



Route::middleware(['auth.custom', 'session.timeout'])->group(function () 
{
 
    Route::get('/list_member', [GymPackageController::class, 'list'])->name('list_member');
    Route::get('/add_member', [GymPackageController::class, 'add'])->name('add_member');
    Route::get('/edit_member/{id}', [GymPackageController::class, 'edit'])->name('edit_package');
   
    Route::middleware(['web'])->group(function () 
    {
        Route::post('/stepper-submit', [GymPackageController::class, 'submit'])->name('stepper.submit');
        Route::post('/stepper-update/{id}', [GymPackageController::class, 'update'])->name('stepper.update');
        Route::get('/members/fetch', [GymPackageController::class, 'fetchMemberList'])
        ->name('fetch_member_list');
    });


   
});



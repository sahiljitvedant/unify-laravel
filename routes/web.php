<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\GymPackageController;
use App\Http\Controllers\Web\GymMembershipController;
use App\Http\Controllers\Web\CompanyController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\TrainerController;
use App\Http\Controllers\Web\PolicyController;
use App\Http\Controllers\Web\EnquiryController;

Route::get('', function () {
    return view('front.index');
})->name('home');
Route::get('/about_us', function () {
    return view('front.about_us');
})->name('about_us');
Route::get('/blogs', function () {
    return view('front.blogs');
})->name('blogs');
Route::get('/blogs_read_more', function () {
    return view('front.blogs_read_more');
})->name('blogs_read_more');
Route::get('/register', [AuthController::class, 'register'])->name('register_get');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register_post');
Route::get('/login', [AuthController::class, 'index'])->name('login_get');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login_post');
Route::post('/enquiry', [EnquiryController::class, 'storeEnquiry'])->name('enquiry.store');

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
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'list'])->name('list_dashboard');
    // Members Route:-
    Route::get('/list_member', [GymPackageController::class, 'list'])->name('list_member');
    Route::get('/add_member', [GymPackageController::class, 'add'])->name('add_member');
    Route::get('/edit_member/{id}', [GymPackageController::class, 'edit'])->name('edit_package');

    // Membersip Route:-
    Route::get('/list_membership', [GymMembershipController::class, 'list'])->name('list_membership');
    Route::get('/add_membership', [GymMembershipController::class, 'add'])->name('add_membership');
    Route::get('/edit_membership/{id}', [GymMembershipController::class, 'edit'])->name('edit_membership');
    Route::get('/list_deleted_membership', [GymMembershipController::class, 'list_deleted_membership'])->name('list_deleted_membership');
    
    // Trainer Route:-
    Route::get('/list_trainer', [TrainerController::class, 'list'])->name('list_trainer');
    Route::get('/add_trainer', [TrainerController::class, 'add'])->name('add_trainer');
    Route::get('/edit_trainer/{id}', [TrainerController::class, 'edit'])->name('edit_trainer');
    Route::get('/list_deleted_trainer', [TrainerController::class, 'list_deleted_trainer'])->name('list_deleted_trainer');
    

    Route::get('/list_policy', [PolicyController::class, 'list'])->name('list_trainer');
    Route::get('/add_policy', [PolicyController::class, 'add'])->name('add_policy');
    Route::get('/edit_policy/{id}', [PolicyController::class, 'edit'])->name('edit_trainer');
    Route::get('/list_deleted_policy', [PolicyController::class, 'list_deleted_trainer'])->name('list_deleted_trainer');
    

    Route::get('/add_company', [CompanyController::class, 'add'])->name('add_company');
    Route::get('/list_company', [CompanyController::class, 'list'])->name('list_company');
    Route::get('/edit_company/{id}', [CompanyController::class, 'edit'])->name('edit_company');

    Route::get('/get_membership_name', [GymMembershipController::class, 'get_membership_name'])
    ->name('get_membership_name');

    Route::middleware(['web'])->group(function () 
    {
        Route::post('/stepper-submit', [GymPackageController::class, 'submit'])->name('stepper.submit');
        Route::post('/stepper-update/{id}', [GymPackageController::class, 'update'])->name('stepper.update');
        Route::get('/members/fetch', [GymPackageController::class, 'fetchMemberList'])
        ->name('fetch_member_list');
        Route::post('/delete_members/{id}', [GymPackageController::class, 'delete_members'])->name('delete_members');

        Route::post('/add_membership', [GymMembershipController::class, 'submit'])->name('add_membership');
        Route::get('/fetch_membership', [GymMembershipController::class, 'fetchMembership'])
        ->name('fetch_membership');
        Route::post('/delete_membership/{id}', [GymMembershipController::class, 'deleteMembership'])->name('delete_membership');
        Route::post('/update_membership/{id}', [GymMembershipController::class, 'update'])->name('update_membership');
        Route::get('/fetch_deleted_membership', [GymMembershipController::class, 'fetch_deleted_membership'])
        ->name('fetch_deleted_membership');
        Route::post('/activate_membership/{id}', [GymMembershipController::class, 'activate_membership'])->name('activate_membership');

        Route::post('/add_trainer', [TrainerController::class, 'submit'])->name('add_trainer');
        Route::get('/fetch_trainer', [TrainerController::class, 'fetch_trainer_list'])
        ->name('fetch_trainer_list');
        Route::post('/delete_trainer/{id}', [TrainerController::class, 'deleteTrainer'])->name('delete_trainer');
        Route::get('/fetch_deleted_trainer', [TrainerController::class, 'fetch_deleted_trainer'])
        ->name('fetch_deleted_trainer');
        Route::post('/activate_trainer/{id}', [TrainerController::class, 'activate_trainer'])->name('activate_trainer');
        Route::post('/update_trainer/{id}', [TrainerController::class, 'update'])->name('update_trainer');
       
        Route::post('/add_policy', [PolicyController::class, 'submit'])->name('add_policy');


        Route::post('/create_company', [CompanyController::class, 'create_company'])->name('create_company');
        Route::get('/fetch_comapny_list', [CompanyController::class, 'fetch_comapny_list'])
        ->name('fetch_comapny_list');
        Route::post('/delete_company/{id}', [CompanyController::class, 'delete_comapny'])->name('delete_company');
        Route::post('/update_home_profile/{id}', [CompanyController::class, 'update_home_profile'])->name('update_home_profile');
        Route::post('/update_company_profile/{id}', [CompanyController::class, 'update_company_profile'])->name('update_company_profile');
    
   
    });
});

Route::get('/debug-log', function () {
    return nl2br(file_get_contents(storage_path('logs/laravel.log')));
});
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return 'DB connection OK';
    } catch (\Exception $e) {
        return 'DB connection failed: ' . $e->getMessage();
    }
});